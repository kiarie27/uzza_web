<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 					= "en/show";
$route['404_override'] 		 					= "en/show/show404";

$route['(:any)/admin/users'] 					= "(:any)/admin/users";
$route['(:any)/users'] 							= "(:any)/show/members";
$route['(:any)/post-ad'] 						= "(:any)/user/new_ad";
$route['(:any)/choose-package'] 				= "(:any)/user/payment/choosepackage";
$route['(:any)/create-ad'] 						= "(:any)/user/create_ad";
$route['(:any)/edit-car/(:any)'] 			= "(:any)/user/editpost/$2/$3";
$route['(:any)/edit-car/(:any)/(:any)'] 	= "(:any)/user/editpost/$2/$3/$4";
$route['(:any)/update-ad'] 						= "(:any)/user/updatepost";
$route['(:any)/admin/content/locations']  		= "(:any)/admin/content/locations";
$route['(:any)/locations'] 						= "(:any)/show/location";
$route['(:any)/location-posts/(:any)/(:any)/(:any)'] 	= "(:any)/show/location_posts/$2/$3/$4";
$route['(:any)/profile/(:any)'] 				= "(:any)/show/memberposts/$2/$3";
$route['(:any)/profile/(:any)/(:any)'] 			= "(:any)/show/memberposts/$2/$3/$4";
$route['(:any)/categories'] 					= "(:any)/show/categories"; 
$route['(:any)/pricing'] 						= "(:any)/show/pricing"; 
$route['(:any)/terms_and_conditions'] 			= "(:any)/show/page/terms_and_conditions"; 
$route['(:any)/cookie_policy'] 					= "(:any)/show/page/cookie_policy"; 
$route['(:any)/featured-cars'] 			= "(:any)/show/featured_cars"; 
$route['(:any)/blog-posts'] 					= "(:any)/show/post/blog";
$route['(:any)/news-posts'] 					= "(:any)/show/post/news";
$route['(:any)/article-posts'] 					= "(:any)/show/post/article";
$route['(:any)/blog-posts/(:any)'] 				= "(:any)/show/post/blog/$2";
$route['(:any)/news-posts/(:any)'] 				= "(:any)/show/post/news/$2";
$route['(:any)/article-posts/(:any)'] 			= "(:any)/show/post/article/$2";
$route['(:any)/post-detail/(:any)/(:any)'] 			= "(:any)/show/postdetail/$2/$3/$4";
$route['(:any)/admin/page/(:any)'] 				= "(:any)/admin/page/$2";
$route['(:any)/page/(:any)'] 					= "(:any)/show/page/$2";
$route['(:any)/contact'] 						= "(:any)/show/contact";
$route['(:any)/sendcontactemail'] 				= "(:any)/show/sendcontactemail";
$route['(:any)/advancesearch'] 					= "(:any)/show/search";
$route['(:any)/results'] 						= "(:any)/show/result";
$route['(:any)/results/(:any)'] 				= "(:any)/show/result/$2";
$route['(:any)/tags/(:any)'] 					= "(:any)/show/tag/$2";
$route['(:any)/car/(:any)'] 					= "(:any)/show/detail/$2";
$route['(:any)/embed/(:any)'] 					= "(:any)/show/embed/$2";

$route['translate_uri_dashes'] = FALSE;

$file 		= './web_config/config.xml';
$xmlstr 	= file_get_contents($file);
$xml 		= simplexml_load_string($xmlstr);
$config		= $xml->xpath('//config');
$is_installed = $config[0]->is_installed;

if($is_installed=='yes')
{
	require_once( BASEPATH .'database/DB'. EXT );
	$db =& DB();
	$query = $db->get_where( 'posts', array('status'=>1) );
	$result = $query->result();
	foreach( $result as $row )
	{
		$route['(:any)/ads/'.$row->unique_id] = "(:any)/show/detail/".$row->unique_id;
	}	
}
