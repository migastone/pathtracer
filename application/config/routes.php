<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] 				= "auth/login";
$route['404_override'] 						= '';

$route['login'] 							= "auth/login";
$route['authenticate'] 						= "auth/authenticate";
$route['logout'] 							= "auth/logout";
$route['profile'] 							= "auth/profile";
$route['update-profile'] 					= "auth/update_profile";
$route['forget-password'] 					= "auth/forget_password";

$route['dashboard'] 						= "administrators/dashboard";
$route['users'] 							= "administrators/list_users";
$route['users/(.*)'] 						= "administrators/list_users/$1";
$route['create-new-user'] 					= "administrators/create_new_user";
$route['save-user'] 						= "administrators/save_user";
$route['update-user-status/(.*)/(.*)'] 		= "administrators/update_user_status/$1/$2";
$route['edit-user/(.*)/(.*)'] 				= "administrators/edit_user/$1/$2";
$route['update-user'] 						= "administrators/update_user";
$route['delete-user/(.*)/(.*)'] 			= "administrators/delete_user/$1/$2";
$route['smtp-settings'] 					= "administrators/smtp_settings";
$route['save-smtp-settings'] 				= "administrators/save_smtp_settings";
$route['registration-settings'] 			= "administrators/registration_settings";
$route['save-registration-settings'] 		= "administrators/save_registration_settings";

$route['clients'] 							= "clients/index";
$route['create-new-client'] 				= "clients/create_new_client";
$route['save-client'] 						= "clients/save_client";
$route['update-client-status/(.*)/(.*)']	= "clients/update_client_status/$1/$2";
$route['edit-client/(.*)'] 					= "clients/edit_client/$1";
$route['update-client'] 					= "clients/update_client";
$route['delete-client/(.*)'] 				= "clients/delete_client/$1";

$route['api'] 								= "Api/index";
$route['api/settings'] 						= "Api/settings";
$route['api/register_me'] 					= "Api/register_me";
$route['api/save_ledger'] 					= "Api/save_ledger";
$route['api/my_status'] 					= "Api/my_status";
$route['api/update_status'] 				= "Api/update_status";

/* End of file routes.php */
/* Location: ./application/config/routes.php */