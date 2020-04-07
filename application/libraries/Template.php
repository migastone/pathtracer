<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Template 
	{
		var $obj;
		var $template;
		
		public function __construct($template = array('template' => 'template'))
		{ 
			$this->obj =& get_instance();
			$this->template =$template['template'];
		}
		
		public function set_template($template)
		{ 
			$this->template = $template;
		}
		
		public function view($view, $data = NULL, $return = FALSE)
		{ 
			$loaded_data = array();
			$loaded_data['content'] =$this->obj->load->view($view, $data, true);
			
			if($return)
			{
				$output = $this->obj->load->view($this->template, $loaded_data, true);
				return $output;
			}
			else
			{ 
				$this->obj->load->view($this->template, $loaded_data, false);
			}
		}
	}
?>
