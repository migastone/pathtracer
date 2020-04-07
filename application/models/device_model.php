<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Device_model extends CI_Model {
	
	protected $_name 	= 'devices';
	protected $_primary = 'device_id';

	public function getDeviceByUuid( $uuid ) {
		return $this->db->get_where( $this->_name , [ 'uuid' => $uuid ] )->row();
	}

	public function getActiveDeviceByUuid( $uuid ) {
		return $this->db->get_where( $this->_name , [ 'uuid' => $uuid , 'status' => 1 ] )->row();
	}

	public function getDeviceById( $device_id ) {
		return $this->db->get_where( $this->_name , [ $this->_primary => $device_id ] )->row();
	}

	public function insertDevice( $data ) {
		$this->db->insert( $this->_name , $data );
		
		return $this->db->insert_id();
	}

	public function updateDeviceByUuid( $uuid , $data = [] ) {
		if ( ! is_null( $uuid ) ) {
			$this->db->where( 'uuid' , $uuid );
			$this->db->update( $this->_name , $data );
		}
	}

	public function getAllDevices() {
		return $this->db->get( $this->_name );
	}

}
