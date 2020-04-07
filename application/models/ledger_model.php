<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Ledger_model extends CI_Model {
	
	protected $_name 	= 'ledgers';
	protected $_primary = 'ledgers_id';

	public function insertLedger( $data ) {
		$this->db->insert( $this->_name , $data );
		
		return $this->db->insert_id();
	}

	public function getPositionsAndDaysByDeviceId( $device_id ) {
		$positions_days = $this->db->query( "SELECT COUNT( ledger_id ) AS total_positions, DATEDIFF( DATE( NOW() ), MIN( DATE( created_at ) ) ) as total_days FROM ledgers WHERE device_id = $device_id" )->row();
		$days = 'few moments';
		$positions = 'no positions';
		if ( ! is_null_or_empty( $positions_days ) ) {
			if ( ! is_null_or_empty( $positions_days->total_positions ) ) {
				$positions = $positions_days->total_positions > 1 ? $positions_days->total_positions . ' positions' : '1 position';
			}
			if ( ! is_null_or_empty( $positions_days->total_days ) ) {
				$days = $positions_days->total_days > 1 ? $positions_days->total_days . ' days' : '1 day';
			}
		}

		return [
			'days' 		=> $days , 
			'positions' => $positions 
		];
	}

	public function getWarning( $device ) {

		$infected_devices = $this->db->query("SELECT GROUP_CONCAT(device_id) AS infected_devices FROM devices WHERE is_infected = 1 AND status = 1" )->row();
		
		if ( is_null_or_empty( $infected_devices ) ) {
			return [];
		}
		$device_ledgers = $this->db->query( "SELECT latitude, longitude, device_timezone, device_created_at, CONVERT_TZ( device_created_at, device_timezone, @@session.time_zone ) AS source_created_at FROM ledgers WHERE device_id = $device->device_id GROUP BY latitude, longitude" );
		if ( $device_ledgers->num_rows() ) {
			$distance_warning_meters  = ( float ) site_setting( 'registration_distance_warning' );
			$distance_warning_minutes = ( int ) site_setting( 'registration_distance_warning_minutes' );
			foreach ( $device_ledgers->result() as $device_ledger ) { 
				$distance = $this->db->query( "SELECT 
													device_id,
													distance
												FROM 
												(
													SELECT 
														CONVERT_TZ( device_created_at, device_timezone, @@session.time_zone ) AS target_created_at, 
														ledgers.*,
														(
															(
																(
																	(
																		acos(
																			sin( ( $device_ledger->latitude * pi() / 180 ) )
																			*
																			sin( ( latitude * pi() / 180 ) ) + cos( ( $device_ledger->latitude * pi() / 180 ) )
																			*
																			cos( ( latitude * pi() / 180 ) ) * cos( ( ( $device_ledger->longitude - longitude ) * pi() / 180 ) ) )
																	) * 180 / pi()
																) * 60 * 1.1515 * 1.609344
															) * 1000
														) as distance FROM ledgers
												) ledgers
												WHERE 
													device_timezone = '$device_ledger->device_timezone' AND 
													DATE( target_created_at ) = DATE( '$device_ledger->source_created_at' ) AND 
													TIMESTAMPDIFF( MINUTE, '$device_ledger->source_created_at', target_created_at ) BETWEEN 1 AND $distance_warning_minutes AND 
													distance <= $distance_warning_meters AND 
													device_id <> $device->device_id AND 
													device_id IN ( $infected_devices->infected_devices ) 
													ORDER BY distance LIMIT 1" 
											)->row();
				if ( ! is_null_or_empty( $distance ) ) {
					return [
						'device_id' => $distance->device_id , 
						'distance'  => number_format( ( float ) $distance->distance , 2 ) , 
						'date' 		=> format_date( $device_ledger->device_created_at ) , 
						'time' 		=> format_time( $device_ledger->device_created_at ) 
					];
				}
			}
		}

		return [];
	}

}
