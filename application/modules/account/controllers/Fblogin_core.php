<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Carbiz fblogin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Account
 * @subpackage	fblogin
 * @author		webhelios
 * @link		http://webhelios.com
 */


class Fblogin_core extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}


	function index()
	{		
		$referer = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'';
		if(stripos("#".$referer, base_url())<=0)
		{
			$result = array();
			$result['url'] 	= '';
			$result['error'] 	= 1;
			$result['msg'] 		= lang_key('fb_login_error_r');
			echo json_encode($result);
			die;			
		}

		$appId  = get_settings('content_settings','fb_app_id','none');
		if(!isset($_COOKIE['fbsr_'.$appId]) || !isset($_COOKIE['fbm_'.$appId]))
		{
			$result = array();
			$result['url'] 	= '';
			$result['error'] 	= 1;
			$result['msg'] 		= lang_key('fb_login_error_c');
			echo json_encode($result);
			die;		
		}

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

			$result = array();

			$user = (isset($_POST))?$_POST:array();
			if(!$this->validate_access_token($user['accessToken']))
			{
				$result['url'] 	= '';
				$result['error'] 	= 1;
				$result['msg'] 		= lang_key('fb_login_error');
				echo json_encode($result);
				die;		
			}

			if(empty($user['email']))
			{
				$result['url'] 	= '';
				$result['error'] 	= 1;
				$result['msg'] 		= lang_key('email_not_shared');
				echo json_encode($result);
				die;
			}

			$user['username']= $user['id'];		
			$this->load->model('auth_model');
			$row = $this->auth_model->register_user_if_not_exists($user);			

			if(is_banned($row['user_email']))
			{
				$result['url'] 	= '';			
				$result['error'] 	= 1;
				$result['msg'] 		= lang_key('user_banned');
				echo json_encode($result);
				die;		
			}
			else
			{
				$this->login($row);			
			}
		}
		else
		{	
			$result = array();
			$result['url'] 	= '';
			$result['error'] 	= 1;
			$result['msg'] 		= lang_key('not_a_ajax_call');
			echo json_encode($result);
			die;		
		}		
	}

	function validate_access_token($accessToken='')
	{
	  $url 	= 'https://graph.facebook.com/me?access_token='.urlencode($accessToken);
	  $ch 	= curl_init(); 
	  curl_setopt($ch, CURLOPT_URL, $url); 
	  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.73 Safari/537.36"); 
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	  curl_setopt($ch, CURLOPT_TIMEOUT, 0); 
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  $response = curl_exec($ch); 
	  //$errmsg = curl_error($ch);  
	  curl_close($ch); 
	  if(!empty($response))
	  {
	  	$data = (array)json_decode($response);
	  	if(isset($data['error']))
	  		return FALSE;
	  	else
	  		return TRUE;
	  }

	}

	function login($row)
	{
		$this->session->set_userdata('user_id',$row['id']);
		$this->session->set_userdata('user_name',$row['user_name']);
		$this->session->set_userdata('user_type',$row['user_type']);
		$this->session->set_userdata('user_email',$row['user_email']);
		$this->session->set_userdata('fbloggeduser',1);

		$result 			= array();

		if($this->session->userdata('req_url')!='')
		{
			$req_url = $this->session->userdata('req_url');
			$this->session->set_userdata('req_url','');
			$result['url'] 	= $req_url;
		}
		else
		{
			$result['url'] 	= site_url();			
		}

		$result['error'] 	= 0;
		$result['msg'] 		= '';
		echo json_encode($result);
		die;
	}

}

?>