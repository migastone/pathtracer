<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Response_model extends CI_Model {
	
	/**
	 * This is the constructor of a Model
	 */
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	
	
	public function error( $error ) {
		
		if ( self::_isJson( $error ) ) {
			$error = json_decode( $error );
		}
		
		return $this->_output( $error , null );
	}
	
	public function data( $data , $error = null ) {

		if ( self::_isJson( $data ) ) {
			$data = json_decode( $data );
		}
		
		return $this->_output( $error , $data );
	}
	
	
	//-----------------------------
	// p r i v a t e
	//-----------------------------
	
	private function _output( $error , $data ) {
		
		header( 'Content-Type: application/json' );
		
		echo json_encode( [ 'error' => $error , 'data' => $data ] , JSON_PRETTY_PRINT );
	}
	
	
	private function _isJson( $string ) {
		
		if ( is_string( $string ) ) {
			json_decode( $string );
			
			return ( json_last_error() == JSON_ERROR_NONE );
		}
		
		return false;
	}
	
}
