<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.');

class Devices extends My_Controller {
	
	public function __construct() { 
		parent::__construct();
		
		$this->isLogin();
		$this->session->userdata( 'nGroupId' ) != 1 ? redirect( '/' ) : '';

		$this->load->model( [ 'device_model' , 'client_model' ] );
	}

	public function index() {
		$this->listening();
	}

	public function listening( $client_id = 0 ) {					
		if ( $this->input->is_ajax_request() ) {
			$where = is_null_or_empty( $client_id ) ? 'WHERE device_id > 0' : "WHERE client_id = $client_id";
			if ( $search = $this->input->get( 'search' ) ) {
				$where .= " AND ( uuid = '$search' OR platform = '$search' OR version = '$search' OR manufacturer = '$search' )";
			}
			if( $this->input->get( 'sort' ) && $this->input->get( 'order' ) ) {
				$where .= " ORDER BY " . $this->input->get( 'sort' ) . " " . $this->input->get( 'order' );
			} else {
				$where .= " ORDER BY created_at DESC";
			}
			$json = [];
			$query = "SELECT device_id, uuid, platform, version, manufacturer, is_infected, infected_marked_by, created_at, last_connection_at, status FROM devices $where LIMIT " . $this->input->get( 'offset' ) . " , " . $this->input->get( 'limit' );
			$json['total'] = $this->db->query( str_replace(" LIMIT " . $this->input->get( 'offset' ) . " , " . $this->input->get( 'limit' ), "" , $query ) )->num_rows();
			foreach ( $this->db->query( $query )->result() as $key => $device ) {
				$device->created_at = format_date( $device->created_at ) . ' ' . format_time( $device->created_at );
				$device->last_connection_at = format_date( $device->last_connection_at ) . ' ' . format_time( $device->last_connection_at );
				$device->status_badge = $device->status ? '<span class="label label-sm label-success"> Enabled </span>' : '<span class="label label-sm label-danger"> Disabled </span>';
				$device->is_infected = $device->is_infected ? '<span class="label label-sm label-danger"> Yes (' . $device->infected_marked_by . ') </span>' : '<span class="label label-sm label-success"> Safe </span>';
				$json['rows'][] = $device;
			}
			echo json_encode( $json );
			exit;
		} else {
			$this->load->view( 'devices' , [
				'page_title' => 'Devices Listening' , 
				'client_id'  => $client_id , 
				'clients' 	 => $this->client_model->getAllClients() , 
			] );
		}
	}

}