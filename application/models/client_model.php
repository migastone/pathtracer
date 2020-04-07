<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Client_model extends CI_Model {

	protected $_name 	= 'clients';
	protected $_primary = 'client_id';

	public function getClientByToken( $token ) {
		return $this->db->get_where( $this->_name , [ 'token' => $token ] )->row();
	}

	public function getAllClients() {
		return $this->db->get( $this->_name );
	}

}
