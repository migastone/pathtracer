<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrators extends My_Controller {
	
	public function __construct()  {
        parent::__construct();
		//hide the errors
		//error_reporting(0);
		//load the required model
		$this->load->model('authentication_model');
		$this->load->model('users_model');
		//if login
		$this->isLogin();
		//if admin
		($this->session->userdata('nGroupId') != 1) ? redirect('/') : '';
	}
	
	public function index() {					
		$this->list_users();
	}

	public function dashboard() 
	{
		$this->load->view('dashboard', [
			'page_title' => 'Dashboard',
		]);
    }
	
	public function list_users($nGroupId = 0)
	{
		if($this->input->is_ajax_request()) //if ajax request is posted
		{
			//where logic
			$strWhere		=	"WHERE users.pk_user_id > 0";
			if($nGroupId > 0)
			{
				$strWhere	=	"WHERE users.fk_group_id = $nGroupId";
			}
			//searching
			if($this->input->get('search'))
			{
				$strSearch		=	$this->input->get('search');
				if($strSearch != "")
				{
					$strWhere  .=	" AND (users.user_first_name LIKE '%$strSearch%' OR users.user_last_name LIKE '%$strSearch%' OR users.user_email LIKE '%$strSearch%' OR users.creation_date LIKE '%$strSearch%' OR groups.group_name LIKE '%$strSearch%')";
				}
			}
			
			//sorting
			if($this->input->get('sort') && $this->input->get('order'))
			{
				//order by
				$strWhere  .=	" ORDER BY ".$this->input->get('sort')." ".$this->input->get('order');
			}
			else
			{
				//order by
				$strWhere  .=	" ORDER BY users.creation_date DESC";
			}
			
			//data query
			$strDataQuery		=	"SELECT users.*, groups.group_name FROM users LEFT JOIN groups ON users.fk_group_id = groups.pk_group_id $strWhere LIMIT ".$this->input->get('offset')." , ".$this->input->get('limit');
										
			$query 				=	$this->db->query($strDataQuery);
			$arrJSON			=	array();
			$queryTotal 		=	$this->db->query(str_replace(" LIMIT ".$this->input->get('offset')." , ".$this->input->get('limit'), "", $strDataQuery));
			$arrJSON['total']	=	$queryTotal->num_rows();
			foreach($query->result() as	$nKey => $objUsers)
			{
				$objUsers->user_c_status 	=	$objUsers->user_status;
				$objUsers->user_status 		=	($objUsers->user_status) ? '<span class="label label-sm label-success"> Enabled </span>' : '<span class="label label-sm label-danger"> Disabled </span>';
				$objUsers->user_first_name 	=	($objUsers->fk_group_id > 1) ? '<a href="'.base_url().'user-details/'.$objUsers->pk_user_id.'">'.$objUsers->user_first_name.'</a>' : $objUsers->user_first_name;
				$objUsers->user_last_name 	=	($objUsers->fk_group_id > 1) ? '<a href="'.base_url().'user-details/'.$objUsers->pk_user_id.'">'.$objUsers->user_last_name.'</a>' : $objUsers->user_last_name;
				$arrJSON['rows'][] = $objUsers;	
			}
			echo json_encode($arrJSON);
			exit;
		}
		else
		{
			//get groups
			$arrGroups	=	$this->authentication_model->get_groups();
			
			//array view data
			$arrData	=	array
							(
								'strPageTitle'	=>	'Users Listening',
								'nGroupId'		=>	$nGroupId,
								'arrGroups'		=>	$arrGroups,
							);
								
			//load the view
			$this->load->view('users', $arrData);
		}
	}
	
	public function create_new_user() 
	{
		//get groups
		$arrGroups	=	$this->authentication_model->get_groups();
			
		//array view data
		$arrData	=	array
						(
							'strPageTitle'	=>	'Create New User',
							'arrGroups'		=>	$arrGroups,
						);
							
		//load the view
		$this->load->view('create_new_user', $arrData);
    }
	
	public function save_user()
	{
		if($this->input->post('user_first_name')) //if data is posted
		{
			//user id
			$nUserId	=	$this->session->userdata('nUserId');
			//get the post array
			$arrData	=	$this->input->post();
			
			//if password is posted
			if($this->input->post('user_password') && $this->input->post('user_password_retype'))
			{
				if($arrData['user_password'] == $arrData['user_password_retype'])
				{
					$arrData['user_password']	=	md5($arrData['user_password']);
					unset($arrData['user_password_retype']);
				}
				else
				{
					$this->session->set_flashdata('error', 'Password mismatch.');
					redirect('create-new-user');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'Password is required.');
				redirect('create-new-user');
			}
			//checking the email already exist
			$strUserEmail	=	strtolower(str_replace(' ', '-', $arrData['user_email']));
			//check if already exist
			$queryCheck	    =	$this->db->query("SELECT pk_user_id FROM users WHERE REPLACE(LOWER(user_email),' ','-') = '$strUserEmail'");
			if($queryCheck->num_rows() > 0) //if already exist
			{
				$this->session->set_flashdata('information', 'Email already exists.');
				redirect('create-new-user');
			}
			else
			{
				//unset retype password
				unset($arrData['user_password_retype']);
				$arrData['user_status	']	=	1;
				$arrData['created_by']		=	$nUserId;
				$arrData['creation_date']	=	date('Y-m-d');
				if($this->db->insert('users', $arrData)) //if data is added
				{
					//new user id
					$nNewUserId				=	$this->db->insert_id();
					//*************************email sending start*************************
					//load the email library
					$this->load->library('email');

					//Setting email configuration
					$this->email->initialize([
						'protocol' => site_setting('smtp_protocol'),
						'smtp_host' => site_setting('smtp_host'),
						'smtp_user' => site_setting('smtp_user'),
						'smtp_pass' => site_setting('smtp_password'),
						'mailtype' => site_setting('smtp_mailtype'),
						'charset' => site_setting('smtp_charset'),
					]);
					$this->email->from(site_setting('smtp_from_email'), site_setting('smtp_from_name'));
					$this->email->to($arrData['user_email']);
					$this->email->bcc(site_setting('smtp_bcc'));
					$this->email->subject('Account Credentials for Miga Licenses');
					
					//message
					$strMessage		=	"Dear ".ucfirst($arrData['user_first_name']).",";
					$strMessage	   .=	"<br />";
					$strMessage    .=	"Your account has been created on Miga Licenses. Below are the credentials:";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"Email: ".$arrData['user_email'];
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"Password: ".$this->input->post('user_password');
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"<a href='".base_url()."'>Click here to login.</a>";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"Thanks,";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	SITE_TITLE . " - Migastone Team";
					
					$this->email->message(nl2br(utf8_encode(htmlspecialchars_decode(htmlentities($strMessage, ENT_NOQUOTES, 'UTF-8'), ENT_NOQUOTES))));
					$this->email->send();
					//*************************email sending end*************************
					
					//redirect based on the group id
					if($this->input->post('fk_group_id') == 1)
					{
						$this->session->set_flashdata('success', 'Admin user has been added successfully.');
						redirect('users');
					}
					else
					{
						$this->session->set_flashdata('success', 'User has been added successfully. Please complete the details below.');
						redirect('users');
					}
				}
			}
		}
		else
		{
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}

	public function edit_user($nUserId = 0, $nGroupId = 0)
	{
		//if not admin
		($this->session->userdata('nGroupId') > 1) ? redirect('/') : '';	
		
		if(($nUserId > 0 && $nGroupId > 0) && $this->session->userdata('nUserId') != $nUserId)
		{
			//get groups
			$arrGroups	=	$this->authentication_model->get_groups();
			
			//get user data
			$arrUser	=	$this->authentication_model->get_user_by_id($nUserId);
			
			//array view data
			$arrData	=	array
							(
								'arrGroups'		=>	$arrGroups,
								'objUser'		=>	$arrUser['results'][0],
								'strPageTitle'	=>	'Edit User'
							);
			
			//load the view
			$this->load->view('edit_user', $arrData);
		}
		else
		{
			redirect('/');
		}
	}
	
	public function update_user()
	{	
		if($this->input->post('user_email')) //if data is posted
		{
			//user id
			$nUserId	=	$this->input->post('pk_user_id');
			//get the post array
			$arrData	=	$this->input->post();
			
			//if password is posted
			if($this->input->post('user_password') && $this->input->post('user_password_retype'))
			{
				if($arrData['user_password'] == $arrData['user_password_retype'])
				{
					$arrData['user_password']	=	md5($arrData['user_password']);
					unset($arrData['user_password_retype']);
				}
				else
				{
					$this->session->set_flashdata('error', 'Password mismatch.');
					redirect('edit-user/'.$nUserId.'/'.$this->input->post('fk_group_id'));
				}
			}
			else
			{
				unset($arrData['user_password']);
				unset($arrData['user_password_retype']);
			}

			//checking the email already exist
			$strUserEmail	=	strtolower(str_replace(' ', '-', $arrData['user_email']));
			//check if already exist
			$queryCheck	    =	$this->db->query("SELECT pk_user_id FROM users WHERE REPLACE(LOWER(user_email),' ','-') = '$strUserEmail' AND pk_user_id <> $nUserId");
			if($queryCheck->num_rows() > 0) //if already exist
			{
				$this->session->set_flashdata('information', 'Email already exists.');
				redirect('edit-user/'.$nUserId.'/'.$this->input->post('fk_group_id'));
			}
			else
			{
				unset($arrData['user_password_retype']);
				unset($arrData['pk_user_id']);
				$this->db->where('pk_user_id', $nUserId);		
				if($this->db->update('users', $arrData)) //if data is updated
				{
					$this->session->set_flashdata('success', 'Account has been updated successfully.');
					redirect('edit-user/'.$nUserId.'/'.$this->input->post('fk_group_id'));
				}
			}
		}
		else
		{
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}
	
	public function update_user_status($nUserId = 0, $nStatus = 0)
	{
		if($nUserId > 0 && $nUserId != $this->session->userdata('nUserId'))
		{
			$arrData					=	array();
			$arrData['user_status	']	=	$nStatus;
			$arrData['updated_by']		=	$nUserId;
			$arrData['updation_date']	=	date('Y-m-d');
			$this->db->where('pk_user_id', $nUserId);
			if($this->db->update('users', $arrData)) //if data is updated
			{
				$this->session->set_flashdata('success', 'Account status has been updated successfully.');
				redirect('users');
			}
		}
		else
		{
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}
	
	public function delete_user($nUserId = 0, $nGroupId = 0)
	{
		if($nUserId > 0 && $nUserId != $this->session->userdata('nUserId') && $nGroupId > 0)
		{
			if($this->db->delete('users',array('pk_user_id' => $nUserId))) //if data is deleted
			{
				$this->session->set_flashdata('success', 'Account has been deleted successfully.');
				redirect('users');
			}
		}
		else
		{
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/dashboard');
		}
	}

	public function smtp_settings() {
		$this->load->model('settings_model');
		$this->load->view('smtp_settings', [
			'page_title' => 'SMTP Settings',
			'settings' => $this->settings_model->getSettingsByPrefix('smtp_%'),
		]);
	}

	public function save_smtp_settings() {
		if($this->input->post('smtp_protocol')) {
			$setting_data = $this->input->post();
			$setting_slugs = array_keys($setting_data);
			foreach($setting_slugs as $setting_slug) {
				$this->db->where('setting_slug', $setting_slug);		
				$this->db->update('settings', [
					'setting_data' => $setting_data[$setting_slug],
					'updated_by' => $this->session->userdata('nUserId'),
					'updation_date' => date('Y-m-d H:i:s'),
				]);
			}
			$this->session->set_flashdata('success', 'SMTP settings are updated successfully.');
			redirect('smtp-settings');
		} else {
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}

	public function registration_settings() {
		$this->load->model('settings_model');
		$this->load->view('registration_settings', [
			'page_title' => 'Registration Settings',
			'settings' => $this->settings_model->getSettingsByPrefix('registration_%')->result(),
		]);
	}

	public function save_registration_settings() {
		if($this->input->post('registration_countries') && $this->input->post('registration_terms_and_conditions')) {
			$setting_data = $this->input->post();
			$setting_slugs = array_keys($setting_data);
			foreach($setting_slugs as $setting_slug) {
				$this->db->where('setting_slug', $setting_slug);		
				$this->db->update('settings', [
					'setting_data' => $setting_slug == 'registration_terms_and_conditions' ? nl2br($setting_data[$setting_slug]) : $setting_data[$setting_slug],
					'updated_by' => $this->session->userdata('nUserId'),
					'updation_date' => date('Y-m-d H:i:s'),
				]);
			}
			$this->session->set_flashdata('success', 'Registration settings are updated successfully.');
			redirect('registration-settings');
		} else {
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}

}
