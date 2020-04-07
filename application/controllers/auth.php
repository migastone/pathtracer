<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends My_Controller {
	
	public function __construct() 
	{
        parent::__construct();
		error_reporting(0);
		//load the required model
		$this->load->model('authentication_model');
	}
	
	public function index()
	{					
		$this->login();
	}
	
	public function login()
	{
		//if already login
		$this->isAlreadyLogin();
		//load the view
		$this->load->view('login');
	}
	
	public function authenticate()
	{
		if($this->input->post('user_email'))
		{
			//get the posted data
			$txtEmail	 	=	$this->input->post('user_email');
			$txtPassword	=	$this->input->post('user_password');		
			
			//validating from model
			$arrUser		=	$this->authentication_model->validate_user($txtEmail, md5($txtPassword));
			
			if($arrUser['num_results'] > 0) //if user exist
			{
				$objUser	=	$arrUser['results'][0];
				if($objUser->user_status < 1) //account is inactive
				{
					$this->session->set_flashdata('information', 'Your account has been disabled.');
					redirect('/');
				}
				else if(!$this->authentication_model->check_group_status($objUser->fk_group_id)) //group is inactive
				{
					$this->session->set_flashdata('information', 'Your group has been disabled.');
					redirect('/');
				}
				else //account is active
				{
					//rememeber me
					if($this->input->post('remember')) 
					{
						setcookie('pc_user_email',$this->input->post('user_email'), time() + (10 * 365 * 24 * 60 * 60));
						setcookie('pc_user_password', $this->input->post('user_password'), time() + (10 * 365 * 24 * 60 * 60));
					}
					//set the sessions
					$arrSessions =	array
									(
										"isLogin" => true, 
										"nUserId" => $objUser->pk_user_id, 
										"strName" => ucfirst($objUser->user_first_name)." ".ucfirst($objUser->user_last_name),
										"strEmail" => $objUser->user_email,
										"nGroupId" => $objUser->fk_group_id,
									);
					$this->session->set_userdata($arrSessions);
					//redirect
					$this->session->set_flashdata('success', 'Login successful.');
					redirect('users');
				}
			}
			else //no such user exists
			{
				$this->session->set_flashdata('information', 'No such user exists.');
				redirect('/');
			}
		}
		else
		{
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}
	
	public function profile()
	{
		//if login
		$this->isLogin();
		
		//get user data
		$arrUser		=	$this->authentication_model->get_user_by_id($this->session->userdata('nUserId'));
		
		//array view data
		$arrData		=	array
							(
								'objUser'		=>	$arrUser['results'][0],
								'strPageTitle'	=>	'My Profile',
							);
		
		//load the view
		$this->load->view('profile', $arrData);
	}
	
	public function update_profile()
	{	
		if($this->input->post('user_email')) //if data is posted
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
					redirect('profile');
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
				redirect('profile');
			}
			else
			{
				unset($arrData['user_password_retype']);
				$this->db->where('pk_user_id', $nUserId);		
				if($this->db->update('users', $arrData)) //if data is updated
				{
					//update the sessions
					$arrSessions	=	array
										(
											"strName"	=>	ucfirst($this->input->post('user_first_name'))." ".ucfirst($this->input->post('user_last_name')),
											"strEmail"	=>	$this->input->post('user_email'),
										);
										
					$this->session->set_userdata($arrSessions);
					
					$this->session->set_flashdata('success', 'Profile has been updated successfully.');
					redirect('profile');
				}
			}
		}
		else
		{
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}
	
	public function logout()
	{
		//if login
		$this->isLogin();
		
		//unset the sessions
		$arrSessions	=	array
							(
								"isLogin"		=>	'', 
								"nUserId"		=>	'', 
								"strName" 		=>	'', 
								"strEmail" 		=>	'',
								"nGroupId"		=>	''
							);
							
		$this->session->unset_userdata($arrSessions);
		//redirect
		$this->session->set_flashdata('success', 'Logout successful.');
		redirect('/');
	}
	
	public function forget_password()
	{
		if($this->input->post('email'))
		{
			//get the posted data
			$txtEmail	=	$this->input->post('email');		
			
			//validating from model
			$arrUser	=	$this->authentication_model->check_email_exists($txtEmail);
			
			if($arrUser['num_results'] > 0) //if user exist
			{
				$nUserId		=	$arrUser['results'][0]->pk_user_id;	
				//generate temp pw
				$strCharacters	=	'0123456789abcdefghijklmnopqrstuvwxyz';
				$strTempPW		=	'';
				for ($i = 0; $i < 6; $i++) 
				{
					$strTempPW  .=	$strCharacters[rand(0, strlen($strCharacters) - 1)];
				}
				//update user pw
				$this->db->where('pk_user_id', $nUserId);		
				if($this->db->update('users', array('user_password' => md5($strTempPW)))) //if data is updated
				{
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
					$this->email->to($txtEmail);
					$this->email->bcc(site_setting('smtp_bcc'));
					$this->email->subject('Forget Password for Miga Licenses');
					
					//message
					$strMessage		=	"Dear ".ucfirst($arrUser['results'][0]->user_first_name).",";
					$strMessage	   .=	"<br />";
					$strMessage    .=	"Your new account credentials are below:";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"Email: ".$arrUser['results'][0]->user_email;
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"Password: ".$strTempPW;
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"<a href='".base_url()."'>Click here to login.</a>";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"Thanks,";
					$strMessage	   .=	"<br />";
					$strMessage	   .=	"Miga Licenses - Migastone Team";
					
					$this->email->message(nl2br(utf8_encode(htmlspecialchars_decode(htmlentities($strMessage, ENT_NOQUOTES, 'UTF-8'), ENT_NOQUOTES))));
					$this->email->send();
					//*************************email sending end*************************
					
					$this->session->set_flashdata('success', 'An email containing new password has been sent to your email address.');
					redirect('/');
				}
			}
			else //no such user exists
			{
				$this->session->set_flashdata('information', 'No such user exists.');
				redirect('/');
			}
		}
		else
		{
			$this->session->set_flashdata('information', 'Invalid access.');
			redirect('/');
		}
	}
}
