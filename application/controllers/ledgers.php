<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.');

class Ledgers extends My_Controller {
	
	public function __construct() { 
		parent::__construct();
		
		$this->isLogin();
		$this->session->userdata( 'nGroupId' ) != 1 ? redirect( '/' ) : '';

		$this->load->model( [ 'ledger_model' , 'device_model' ] );
	}

	public function index() {
		$this->listening();
	}

	public function listening( $device_id = 0 ) {					
		if ( $this->input->is_ajax_request() ) {
			$where = is_null_or_empty( $device_id ) ? 'WHERE ledgers.ledger_id > 0' : "WHERE ledgers.device_id = $device_id";
			if ( $search = $this->input->get( 'search' ) ) {
				$where .= " AND ( devices.uuid = '$search' OR ledgers.latitude = '$search' OR ledgers.longitude = '$search' OR ledgers.device_timezone = '$search' )";
			}
			if( $this->input->get( 'sort' ) && $this->input->get( 'order' ) ) {
				$where .= " ORDER BY " . $this->input->get( 'sort' ) . " " . $this->input->get( 'order' );
			} else {
				$where .= " ORDER BY created_at DESC";
			}
			$json = [];
			$query = "SELECT ledgers.*, devices.uuid FROM ledgers INNER JOIN devices ON ledgers.device_id = devices.device_id $where LIMIT " . $this->input->get( 'offset' ) . " , " . $this->input->get( 'limit' );
			$json['total'] = $this->db->query( str_replace(" LIMIT " . $this->input->get( 'offset' ) . " , " . $this->input->get( 'limit' ), "" , $query ) )->num_rows();
			foreach ( $this->db->query( $query )->result() as $key => $ledger ) {
				$ledger->device_created_at = format_date( $ledger->device_created_at ) . ' ' . format_time( $ledger->device_created_at );
				$ledger->created_at = format_date( $ledger->created_at ) . ' ' . format_time( $ledger->created_at );
				$json['rows'][] = $ledger;
			}
			echo json_encode( $json );
			exit;
		} else {
			$device = $this->device_model->getDeviceById( $device_id );
			$this->load->view( 'ledgers' , [
				'page_title' => 'Ledgers Listening' . (! is_null_or_empty( $device ) ? ' (' . $device->uuid . ')' : ''), 
				'device_id'  => $device_id ,
				'device'	 => $device ,  
				'devices' 	 => $this->device_model->getAllDevices() , 
			] );
		}
	}

}