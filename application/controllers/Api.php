<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * @property Response_model    	response_model
 * @property Client_model      	client_model
 * @property Settings_model     settings_model
 * @property Device_model       device_model
 * @property Ledger_model       ledger_model
 */
class Api extends CI_Controller {

	const API_VERSION = '1.0.0';
	const TOKEN_KEY = 'o4FLb6OWVq6vXgaes1zNS0NDKhQM44';

	private $_client = null;

	private $_valid_parameters = [
		self::TOKEN_KEY , 
		'country' , 
		'latitude' , 
		'longitude' , 
		'platform' , 
		'uuid' , 
		'version' , 
		'manufacturer' , 
		'device_created_at' , 
		'ledger_posts' , 
		'is_infected' , 
		'infected_marked_by' , 
		'device_infected_at' , 
		'device_timezone' , 
	];
	
	public function __construct() {
		parent::__construct();

		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Methods: GET, OPTIONS' );

		$this->load->model( [ 'response_model' , 'client_model' , 'settings_model' , 'device_model' , 'ledger_model'] );
		$this->load->library( [ 'form_validation' ] );

		if ( ! site_setting( 'registration_is_feature_enabled' ) ) {
			$this->response_model->error( site_setting( 'registration_disabled_reason' ) );
			die( '' );
		}

		if ( ! $this->input->get() ) {
			$this->response_model->error( 'Invalid Access.' );
			die( '' );
		}
		
		if ( count( array_intersect( array_keys( $this->input->get() ) , $this->_valid_parameters ) ) != count( $this->input->get() ) ) {
			$this->response_model->error( 'Invalid Parameter(s) Found.' );
			die( '' );
		}

		if ( ! array_key_exists( self::TOKEN_KEY , $this->input->get() ) ) {
			$this->response_model->error( 'No Token Key Posted.' );
			die( '' );
		}

		if ( ! $this->input->get( self::TOKEN_KEY ) ) {
			$this->response_model->error( 'No Token Posted.' );
			die( '' );
		}

		$token = $this->input->get( self::TOKEN_KEY );
		$this->client = $this->client_model->getClientByToken( $token );
		if ( is_null_or_empty( $this->client ) ) {
			$this->response_model->error( 'Invalid Token.' );
			die( '' );
		}

		if ( is_null_or_empty( $this->client->status ) ) {
			$this->response_model->error( 'Your account has been disabled.' );
			die( '' );
		}
	}
	
	public function index() {
		return $this->response_model->data( [
			'status'  => 'Virus Path Tracer API Running' ,
			'version' => self::API_VERSION
		] );
	}
	
	public function settings() {
		return $this->response_model->data( $this->_get_settings() );
	}
	
	public function register_me() {

		$errors = "";

		if ( ! $this->input->get( 'latitude' ) ) {
			$errors .= 'Latitude missing.<br/>';
		}

		if ( ! $this->input->get( 'longitude' ) ) {
			$errors .= 'Longitude missing.<br/>';
		}

		if ( ! $this->input->get( 'country' ) ) {
			$errors .= 'Country not selected.<br/>';
		}

		if ( ! $this->input->get( 'uuid' ) ) {
			$errors .= 'Device uuid missing.<br/>';
		}

		if ( $errors ) {
			return $this->response_model->error( $errors );
		}

		$error 	= null;
		$device = $this->device_model->getDeviceByUuid( $this->input->get( 'uuid' ) );
		if ( ! is_null_or_empty( $device ) ) {
			$error = 'The registration process is completed but this is not a new registration as we have found your existing data on our server.';
			$this->device_model->updateDeviceByUuid( $this->input->get( 'uuid' ) , [ 'status' => 0 , 'updated_at' => date( 'Y-m-d H:i:s' ) ] );
		}
		
		$data = [
			'client_id'    		 => $this->client->client_id ,
			'country'     		 => $this->input->get( 'country' ) ,
			'platform'     		 => $this->input->get( 'platform' ) ,
			'uuid'         		 => $this->input->get( 'uuid' ) ,
			'version'     		 => $this->input->get( 'version' ) ,
			'manufacturer' 		 => $this->input->get( 'manufacturer' ) ,
			'last_connection_at' => date( 'Y-m-d H:i:s' ) ,
			'created_at'   		 => date( 'Y-m-d H:i:s' ) ,
		];
		$device_id = $this->device_model->insertDevice( $data );

		$ledger_id = $this->ledger_model->insertLedger( [
			'device_id'       	=> $device_id ,
			'latitude'         	=> doubleval( $this->input->get( 'latitude' ) ) ,
			'longitude'         => doubleval( $this->input->get( 'longitude' ) ) ,
			'device_timezone'	=> $this->input->get( 'device_timezone' ) , 
			'device_created_at' => date( 'Y-m-d H:i:s' ) , 
			'created_at' 		=> date( 'Y-m-d H:i:s' ) , 
		] );
		$data[ 'latitude' ] = $this->input->get( 'latitude' );
		$data[ 'longitude' ] = $this->input->get( 'longitude' );
		return $this->response_model->data( $data , $error );

	}

	public function save_ledger() {

		$error = null;
		$data = [];
		$device = $this->device_model->getActiveDeviceByUuid( $this->input->get( 'uuid' ) );
		if ( ! is_null_or_empty( $device ) ) {
			$ledgers = json_decode( $this->input->get( 'ledger_posts' ) );
			foreach( $ledgers as $ledger ) {
				$data = [
					'device_id'       	=> $device->device_id ,
					'latitude'         	=> doubleval( $ledger->latitude ) ,
					'longitude'         => doubleval( $ledger->longitude ) ,
					'device_timezone'	=> $ledger->device_timezone ,
					'device_created_at' => $ledger->device_created_at ,
					'created_at' 		=> date( 'Y-m-d H:i:s' ) 
				];
				$ledger_id = $this->ledger_model->insertLedger( $data );

				$data = array_merge( $data , $this->_get_status( $this->input->get( 'uuid' ) ) );
			}
			$this->device_model->updateDeviceByUuid( $this->input->get( 'uuid' ) , [ 'last_connection_at' => date( 'Y-m-d H:i:s' ) , 'updated_at' => date( 'Y-m-d H:i:s' ) ] );
			$error = $ledger_id ? null : 'Unable to save the data to ledger.';
		} else {
			$error = 'No device found.';
		}

		return $this->response_model->data( $data , $error );

	}

	public function my_status() {

		$error 	= null;
		$data 	= $this->_get_settings();
		$device = $this->device_model->getActiveDeviceByUuid( $this->input->get( 'uuid' ) );
		if ( ! is_null_or_empty( $device ) ) {
			$data = array_merge( $data , ( array ) $device , $this->_get_status( $this->input->get( 'uuid' ) ) );
		} else {
			$error = 'No device found.';
			$data  = null;
		}

		return $this->response_model->data( $data , $error );
	}

	public function update_status() {

		$error = null;
		$data = [];
		$device = $this->device_model->getActiveDeviceByUuid( $this->input->get( 'uuid' ) );
		if ( ! is_null_or_empty( $device ) ) {
			$data = [
				'is_infected'        => $this->input->get( 'is_infected' ) ,
				'infected_marked_by' => $this->input->get( 'infected_marked_by' ) ,
				'infected_at'        => $this->input->get( 'is_infected' ) ? date('Y-m-d H:i:s') : null ,
				'device_infected_at' => $this->input->get( 'is_infected' ) ? $this->input->get( 'device_infected_at' ) : null ,
				'last_connection_at' => date( 'Y-m-d H:i:s' ) ,
				'updated_at' 		 => date( 'Y-m-d H:i:s' )
			];
			$this->device_model->updateDeviceByUuid( $this->input->get( 'uuid' ) , $data );
			
			$device = $this->device_model->getActiveDeviceByUuid( $this->input->get( 'uuid' ) );
			$data = array_merge( $data , $this->_get_status( $this->input->get( 'uuid' ) ) );
		} else {
			$error = 'No device found.';
		}

		return $this->response_model->data( $data , $error );

	}

	private function _get_settings() {
		$settings = [];
		$registration_settings = $this->settings_model->getSettingsByPrefix( 'registration_%' )->result();
		foreach ( $registration_settings as $registration_setting ) {
			if ($registration_setting->setting_slug == 'registration_countries' ) {
				$settings[ 'countries' ] = array_map( 'trim' , explode( ',' , $registration_setting->setting_data ) );
			} else {
				$settings[ $registration_setting->setting_slug ] = $registration_setting->setting_data;
			}
		}

		return $settings;
	}

	private function _get_status( $uuid ) {
		
		$settings = $this->_get_settings();
		$can_update_status = true;
		$is_send_push = null;
		$device = $this->device_model->getActiveDeviceByUuid( $uuid );
		switch ( $device->is_infected ) {
			case 0:
				$positions_days = $this->ledger_model->getPositionsAndDaysByDeviceId( $device->device_id );
				$warning = $this->ledger_model->getWarning( $device );
				if ( count( $warning ) ) {
					$infected_device = $this->device_model->getDeviceById( $warning[ 'device_id' ] );
					if ( ! ($device->infected_device_id == $warning['device_id'] && $device->infected_device_distance == $warning[ 'distance' ] ) ) {
						$is_send_push = true;
						$this->device_model->updateDeviceByUuid( $device->uuid , [
							'infected_device_distance'  => $warning[ 'distance' ] , 
							'infected_device_id'   		=> $warning[ 'device_id' ] , 
							'infected_device_date' 		=> date( 'Y-m-d H:i:s' ) , 
							'last_connection_at'   		=> date( 'Y-m-d H:i:s' ) , 
							'updated_at' 		   		=> date( 'Y-m-d H:i:s' ) 
						] );
					}
					$status_class = 'status-warning';
					$status_title = $settings[ 'registration_status_warning_title' ];
					$status_text = str_replace(
						[
							'@@positions@@' ,  
							'@@date@@' , 
							'@@time@@' , 
							'@@distance@@' ,  
							'@@authority@@' 
						] , 
						[
							$positions_days[ 'positions' ] , 
							$warning[ 'date' ] , 
							$warning[ 'time' ] , 
							$warning[ 'distance' ] > 1 ? $warning[ 'distance' ] . ' meters' : $warning[ 'distance' ] . ' meter' , 
							$infected_device->infected_marked_by == 'Self' ? 'The warning is based on self-report made by another user. Verify this information with the authorities or your doctor' : 'The warning is based on a certified infection report from authorities' 
						] , 
						$settings[ 'registration_status_warning_text' ] 
					);
				} else {
					$status_class = 'status-safe';
					$status_title = $settings[ 'registration_status_safe_title' ];
					$status_text = str_replace(
						[
							'@@positions@@' , 
							'@@days@@' 
						] , 
						[
							$positions_days[ 'positions' ] , 
							$positions_days[ 'days' ] 
						] , 
						$settings[ 'registration_status_safe_text' ] 
					);
				}
			break;

			case 1:
				$status_class = 'status-infected';
				$status_title = $settings[ 'registration_status_infected_title' ];
				switch ( $device->infected_marked_by ) {
					case 'Self':
						$status_text = str_replace(
							[
								'@@infected_marked_by@@' , 
								'@@date@@' , 
								'@@time@@' 
							] , 
							[
								'You submitted the self-declaration' , 
								format_date( $device->device_infected_at ) , 
								format_time( $device->device_infected_at ) 
							] , 
							$settings[ 'registration_status_infected_text' ] 
						);
					break;

					case 'System':
						$can_update_status = null;
						$status_text = str_replace(
							[
								'@@infected_marked_by@@' , 
								'@@date@@' , 
								'@@time@@' 
							] , 
							[
								'An authority has verified' , 
								format_date( $device->infected_at ) , 
								format_time( $device->infected_at ) 
							] , 
							$settings[ 'registration_status_infected_text' ] 
						);
					break;
				}
			break;
		}

		return [
			'status_title'		=> $status_title , 
			'status_text' 		=> $status_text , 
			'status_class'		=> $status_class , 
			'can_update_status'	=> $can_update_status , 
			'is_send_push'		=> $is_send_push 
		];

	}
	
}
