<?php
class Settings_model extends CI_Model {	
	
	function getSetting($setting_slug = '') {
		return $this->db->get_where('settings', ['setting_slug' => $setting_slug]);
	}

	function getSettingsByPrefix($prefix = '') {
		return $this->db->query("SELECT setting_slug, setting_data FROM settings WHERE setting_slug LIKE '$prefix'");
	}
	
}
?>