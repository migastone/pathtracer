<?php

	if ( ! function_exists( 'format_date' ) ) {
		/**
		 * @param date $custom_date
		 *
		 * @return date
		 */
		function format_date( $custom_date ) {
			
			return str_replace( '-' , '/' , date( 'd-m-Y' , strtotime( $custom_date ) ) );
		}
	}

	if ( ! function_exists( 'format_time' ) ) {
		/**
		 * @param date $custom_time
		 *
		 * @return time
		 */
		function format_time( $custom_time ) {
			
			return date( 'H:i' , strtotime( $custom_time ) );
		}
	}

	if ( ! function_exists( 'is_null_or_empty' ) ) {
		/**
		 * @param mixed $string
		 *
		 * @return bool
		 */
		function is_null_or_empty( $string ) {
			
			if ( is_null( $string ) ) {
				return true;
			}
			
			if ( is_string( $string ) ) {
				$string = trim( $string );
			}
			
			return empty( $string );
		}
	}

	/**
	 * get_os
	 *
	 * It will return the user's os name
	 *
	 * @param (string) (user_agent) contains the HTTP_USER_AGENT
	 *
	 * @return string
	 * 
	 */
	if(!function_exists('get_os')) {
		function get_os($user_agent = '') {
			$os_platform = "Unknown OS Platform";
			$os_array = [
				'/windows nt 10/i'      =>  'Windows 10',
				'/windows nt 6.3/i'     =>  'Windows 8.1',
				'/windows nt 6.2/i'     =>  'Windows 8',
				'/windows nt 6.1/i'     =>  'Windows 7',
				'/windows nt 6.0/i'     =>  'Windows Vista',
				'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
				'/windows nt 5.1/i'     =>  'Windows XP',
				'/windows xp/i'         =>  'Windows XP',
				'/windows nt 5.0/i'     =>  'Windows 2000',
				'/windows me/i'         =>  'Windows ME',
				'/win98/i'              =>  'Windows 98',
				'/win95/i'              =>  'Windows 95',
				'/win16/i'              =>  'Windows 3.11',
				'/macintosh|mac os x/i' =>  'Mac OS X',
				'/mac_powerpc/i'        =>  'Mac OS 9',
				'/linux/i'              =>  'Linux',
				'/ubuntu/i'             =>  'Ubuntu',
				'/iphone/i'             =>  'iPhone',
				'/ipod/i'               =>  'iPod',
				'/ipad/i'               =>  'iPad',
				'/android/i'            =>  'Android',
				'/blackberry/i'         =>  'BlackBerry',
				'/webos/i'              =>  'Mobile'
			];

			foreach($os_array as $regex => $value)
				if(preg_match($regex, $user_agent))
					$os_platform = $value;

			return $os_platform;
		}
	}

	/**
	 * get_browser
	 *
	 * It will return the user's browser name
	 *
	 * @param (string) (user_agent) contains the HTTP_USER_AGENT
	 *
	 * @return string
	 * 
	 */
	if(!function_exists('get_browser')) {
		function get_browser($user_agent = '') {
			$browser = "Unknown Browser";
			$browser_array = [
				'/msie/i'      => 'Internet Explorer',
				'/firefox/i'   => 'Firefox',
				'/safari/i'    => 'Safari',
				'/chrome/i'    => 'Chrome',
				'/edge/i'      => 'Edge',
				'/opera/i'     => 'Opera',
				'/netscape/i'  => 'Netscape',
				'/maxthon/i'   => 'Maxthon',
				'/konqueror/i' => 'Konqueror',
				'/mobile/i'    => 'Handheld Browser'
			];

			foreach($os_array as $regex => $value)
				if(preg_match($regex, $user_agent))
					$os_platform = $value;

			return $os_platform;
		}
	}

	/**
	 * get_youtube_rmbed_url
	 *
	 * it will convert youtube url to embed url
	 *
	 * @param (string) (url) contains the video url
	 *
	 * @return string
	 * 
	 */
	if(!function_exists('get_youtube_rmbed_url')) { 
		function get_youtube_rmbed_url($url = ''){
			parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
			return 'https://www.youtube.com/embed/' . $my_array_of_vars['v'] ;
		}
	}

	/**
	 * __
	 *
	 * it will return translation of a given string
	 *
	 * @param (string) (code) contains the message code	
	 *
	 * @return string
	 * 
	 */
    if(!function_exists('__')) {
        function __($code = '') {
            $translations = [
				'auth_account_disabled' => [
					'en' => 'Your account has been disabled.',
					'it' => 'Il tuo account è stato disabilitato.',
				],
				'auth_group_disabled' => [
					'en' => 'Your group has been disabled.',
					'it' => 'Il tuo gruppo è stato disabilitato.',
				],
				'auth_no_user' => [
					'en' => 'No such user exists.',
					'it' => 'Non esiste tale utente.',
				],
				'auth_login_success' => [
					'en' => 'No such user exists.',
					'it' => 'Non esiste tale utente.',
				],
				'system_invalid_access' => [
					'en' => 'Invalid access.',
					'it' => 'Accesso non valido.',
				],
				'system_fallback' => [
					'en' => 'There is some error.',
					'it' => 'C\'è qualche errore.',
				],
			];
        }
    }

	/**
	 * site_setting
	 *
	 * get setting value by id
	 *
	 * @param (string) (slug) contains setting code
	 *
	 * @return string
	 * 
	 */
    if(!function_exists('site_setting')) {
        function site_setting($slug = '') {
            $CI = &get_instance();
            $CI->load->model('settings_model');
            $setting = $CI->settings_model->getSetting($slug);
			return $setting->num_rows() ? $setting->result()[0]->setting_data : 'NOT FOUND';
        }
    }

	/**
	 * add_log
	 *
	 * add the errors related to the api into the database
	 *
	 * @param (string) (message) contains error message
	 * @param (int) (module_id) contains module id
	 * @param (int) (customer_id) contains customer id
	 * @param (int) (license_id) contains license id
	 *
	 * @return bool
		 * 
	 */
    if(!function_exists('add_log'))
    {
        function add_log($message = '', $module_id = 0, $customer_id = 0, $license_id = 0)
        {
            $CI = &get_instance();
            $CI->load->model('modules_model');
            return $CI->modules_model->add_log($message, $module_id, $customer_id, $license_id);
        }
    }

	/**
	 * guid
	 *
	 * generate license key
	 * 
	 */
	if(!function_exists('guid')) 
	{
		function guid()
		{
			return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
		}
	}

	/**
     * @param date $url
     * @return string
     */
	if(!function_exists('get_tiny_url'))  {
		function get_tiny_url($url = '')  {  
			$ch = curl_init();  
			$timeout = 5;  
			curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeout);  
			$data = curl_exec($ch);  
			curl_close($ch);  
			return $data;  
		}
	}

	/**
	 * encode_base_url
	 *
	 * will encode the base url
	 * 
	 * @param (string) ($url) contains url to be encoded
	 *
	 * @return string
	 * 
	 */
	if(!function_exists('encode_base_url')) 
	{
		function encode_base_url($url)
		{
			return base64_encode(base64_encode($url));
		}
	}

	/**
	 * decode_base_url
	 *
	 * will decode the base url
	 * 
	 * @param (string) ($url) contains url to be decoded
	 *
	 * @return string
	 * 
	 */
	if(!function_exists('decode_base_url')) 
	{
		function decode_base_url($url)
		{
			return base64_decode(base64_decode($url));
		}
	}

	/**
	 * encode_license
	 *
	 * will encode the license
	 * 
	 * @param (string) ($license) contains license to be encoded
	 *
	 * @return string
	 * 
	 */
	if(!function_exists('encode_license')) 
	{
		function encode_license($license) 
		{
			$result = "";
			for($i = 0; $i >= 4; $i++) 
			{
				$result = base64_encode($license);
			}
			return md5(sha1($result));
		}
	}

	/**
	 * check_license
	 *
	 * will check the license
	 * 
	 * @param (string) ($license) contains license to be checked
	 *
	 * @return string
	 * 
	 */
	if(!function_exists('check_license'))
	{
		function check_license($license) 
		{
			return $encoded_license == encode_license($license);
		}
	}

	/**
	 * url_exist
	 *
	 * will check if url is valid and exists
	 * 
	 * @param (string) ($url) contains url to be checked
	 *
	 * @return bool
	 * 
	 */
	if(!function_exists('url_exist'))
	{
		function url_exist($url)
		{
			$ch = @curl_init($url);
			@curl_setopt($ch, CURLOPT_HEADER, true);// we want headers
			@curl_setopt($ch, CURLOPT_NOBODY, true);// dont need body
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// catch output (do NOT print!)
			@curl_exec($ch);
			if(@curl_errno($ch))
			{
				@curl_close($ch);
				return false;
			}
			$code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);// get response code
			@curl_close($ch);
			return $code == 200 ? true : false;
		}
	}
?>