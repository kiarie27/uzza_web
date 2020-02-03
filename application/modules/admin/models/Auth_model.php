<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Carbiz auth_model_core model
 *
 * This class handles auth_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	auth_model_core
 * @author		webhelios
 * @link		http://webhelios.com
 */
require_once'Auth_model_core.php';
class Auth_model extends Auth_model_core {

	public function __construct()
	{
		parent::__construct();
	}
}