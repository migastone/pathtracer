<?php
class Authentication_model extends CI_Model
{	
	function validate_user($strEmail, $strPassword)
	{
		$query = $this->db->get_where('users', array('user_email' => $strEmail, 'user_password' => $strPassword));
		
		return array('results' => $query->result(), 'num_results' => $query->num_rows());
	}
	
	function check_email_exists($strEmail)
	{
		$query = $this->db->get_where('users', array('user_email' => $strEmail));
		
		return array('results' => $query->result(), 'num_results' => $query->num_rows());
	}
	
	function get_user_by_id($nUserId = 0)
    {       
		$query = $this->db->get_where('users', array('pk_user_id' => $nUserId));
        
		return array('results' => $query->result(), 'num_results' => $query->num_rows());
    }
	
	function check_group_status($nGroupId = 0)
    {       
		$query = $this->db->get_where('groups', array('pk_group_id' => $nGroupId, 'group_status' => 1));
        
		return ($query->num_rows()) ? true : false;
    }
	
	function get_groups()
    {       
		$query = $this->db->get('groups');
        
		return array('results' => $query->result(), 'num_results' => $query->num_rows());
    }
}
?>