<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.');

class Clients extends My_Controller {
	
	public function __construct()  { 
        parent::__construct();
		$this->isLogin();
		$this->session->userdata('nGroupId') != 1 ? redirect('/') : '';
	}

	public function index() {					
		if($this->input->is_ajax_request()) {
			$where = 'WHERE client_id > 0';
			if($search = $this->input->get('search')) {
				$where .= " AND (title LIKE '%$search%' OR description LIKE '%$search%' OR token = '$search')";
			}
			if($this->input->get('sort') && $this->input->get('order')) {
				$where .= " ORDER BY ".$this->input->get('sort')." ".$this->input->get('order');
			} else {
				$where .= " ORDER BY created_at DESC";
			}
			$json = [];
			$query = "SELECT * FROM clients $where LIMIT ".$this->input->get('offset')." , ".$this->input->get('limit');
			$json['total'] = $this->db->query(str_replace(" LIMIT ".$this->input->get('offset')." , ".$this->input->get('limit'), "", $query))->num_rows();
			foreach($this->db->query($query)->result() as $key => $client) {
				//$client->last_connection_at = is_null($client->last_connection_at) || $client->last_connection_at == '0000-00-00 00:00:00' ? 'N/A' : $client->last_connection_at;
				$client->updated_at = is_null($client->updated_at) || $client->updated_at == '0000-00-00 00:00:00' ? 'N/A' : $client->updated_at;
				$json['rows'][] = $client;
			}
			echo json_encode($json);
			exit;
		} else {
			$this->load->view('clients', [
				'page_title' => 'Clients Listening',
			]);
		}
	}

	public function create_new_client() {
		$this->load->view('create_new_client', [
			'page_title' => 'Create New Client',
		]);
	}
	
	public function save_client() {
		if($data = $this->input->post()) {
			$title = strtolower(str_replace(' ', '-', $data['title']));
			$query = $this->db->query("SELECT client_id FROM clients WHERE REPLACE(LOWER(title),' ','-') = '$title'");
			if($query->num_rows()) {
				$this->session->set_flashdata('information', 'Title already exists.');
				redirect('create-new-client');
			} else {
				if($this->db->insert('clients', $data)) {
					$this->session->set_flashdata('success', 'Client has been added successfully.');
					redirect('clients');
				}
			}
		} else {
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}

	public function edit_client($client_id = 0) {
		$this->load->view('edit_client', [
			'page_title' => 'Edit Client',
			'client' => $this->db->get_where('clients', ['client_id' => $client_id])->result()[0],
		]);
	}

	public function update_client() {
		if($data = $this->input->post()) {
			$title = strtolower(str_replace(' ', '-', $data['title']));
			$client_id = $data['client_id'];
			$query = $this->db->query("SELECT client_id FROM clients WHERE REPLACE(LOWER(title),' ','-') = '$title' AND client_id <> $client_id");
			if($query->num_rows()) {
				$this->session->set_flashdata('information', 'Title already exists.');
				redirect('edit-client/' . $client_id);
			} else {
				unset($data['client_id']);
				$data['updated_at'] = date('Y-m-d H:i:s');
				$this->db->where('client_id', $client_id);
				if($this->db->update('clients', $data)) {
					$this->session->set_flashdata('success', 'Client has been updated successfully.');
					redirect('edit-client/' . $client_id);
				}
			}
		} else {
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}

	public function update_client_status($client_id = 0, $status = 0) {
		if($client_id) {
			$this->db->where('client_id', $client_id);
			if($this->db->update('clients', ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')])) {
				$this->session->set_flashdata('success', 'Client\'s status has been updated successfully.');
				redirect('clients');
			}
		} else {
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}

	public function delete_client($client_id = 0) {
		if($client_id && $this->db->delete('clients', ['client_id' => $client_id])) {
			$this->session->set_flashdata('success', 'Client has been deleted successfully.');
			redirect('clients');
		} else {
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}

}