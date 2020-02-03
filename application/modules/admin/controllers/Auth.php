<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Carbiz Auth Controller
 *
 * This class handles Auth management related functionality
 *
 * @package		Admin
 * @subpackage	Auth
 * @author		webhelios
 * @link		http://webhelios.com
 */
require_once'Auth_core.php';
class Auth extends Auth_core {

	public function __construct()
	{
		parent::__construct();
	}
}