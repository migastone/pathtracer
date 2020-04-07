<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() 
	{
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->common_assets();
    }
	
    public function common_assets() 
	{
        $css_files = array(
            css_url() . 'bootstrap.css',
            css_url() . 'style.css'
        );

        foreach ($css_files as $css_file)
		{
            $this->dynamic_load->add_css(array('href' => $css_file, 'rel' => 'stylesheet', 'type' => 'text/css'));
		}
		
        $js_files = array(
            js_url() . 'bootstrap.js',
            js_url() . 'custom.scripts.js',
        );

        foreach ($js_files as $js_file)
		{
            $this->dynamic_load->add_js('footer', array('src' => $js_file, 'type' => 'text/javascript'));
		}
    }

	public function isAlreadyLogin() 
	{
        if($this->session->userdata('isLogin')) 
		{
			($this->session->userdata('nGroupId') == 1) ? redirect('dashboard') : redirect('my-dashboard');
            exit;
        }
    }
	
	public function isLogin() 
	{
        if($this->session->userdata('isLogin') == FALSE) 
		{
            //set the sessions
			$arrSessions	=	array
								(
									"isLogin"		=>	'', 
									"nUserId"		=>	'', 
									"strName" 		=>	'', 
									"strEmail" 		=>	'',
									"nGroupId" 		=>	'',
									"strTimezone"	=>	''
								);
			$this->session->set_userdata($arrSessions);
			$this->session->set_flashdata('information', 'You have to login first.');
            redirect('/');
            exit;
        }
    }
	
	public function number_manipulator($nNumber = 0) 
	{
        if($nNumber) 
		{
			return ($nNumber < 10) ? '0'.$nNumber : $nNumber; 
		}
		
		return '00';
    }

    public function secure_data($data) 
	{
        return $this->security->xss_clean(trim($data));
    }
}

/* End of file My_Controller.php */
/* Location: ./application/core/My_Controller.php */