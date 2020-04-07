<?php
class Users_model extends CI_Model
{	
	function is_admin($nUserId = 0) {
		$query = $this->db->get_where('users', array('pk_user_id' => $nUserId, 'fk_group_id' => 1));
		return ($query->num_rows()) ? true : false;
	}

	function get_all_users() {
		$query = $this->db->get('users');
		return array('results' => $query->result(), 'num_results' => $query->num_rows());
	}
}
?>