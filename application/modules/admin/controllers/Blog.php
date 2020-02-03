<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Carbiz blog Controller
 *
 * This class handles blog management related functionality
 *
 * @package		Admin
 * @subpackage	blog
 * @author		webhelios
 * @link		http://webhelios.com
 */

require_once'Blog_core.php';

class Blog extends Blog_core {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
}

/* End of file blog.php */
/* Location: ./application/modules/admin/controllers/blog.php */