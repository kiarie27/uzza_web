<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter router class.
 *
 * Install this file as application/third_party/MX/Router.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Router extends CI_Router
{
	public $module;
	private $located = 0;

	public function fetch_module()
	{
		return $this->module;
	}

	protected function _set_request($segments = array())
	{
		if ($this->translate_uri_dashes === TRUE)
		{
			foreach(range(0, 2) as $v)
			{
				isset($segments[$v]) && $segments[$v] = str_replace('-', '_', $segments[$v]);
			}
		}
		
		$segments = $this->locate($segments);

		
		if($this->located == -1 || isset($segments['404']))
		{
			$this->_set_404override_controller();
			return;
		}

		if(empty($segments))
		{
			$this->_set_default_controller();
			return;
		}
		
		$this->set_class($segments[0]);
		
		if (isset($segments[1]))
		{
			$this->set_method($segments[1]);
		}
		else
		{
			$segments[1] = 'index';
		}
       
		array_unshift($segments, NULL);
		unset($segments[0]);
		$this->uri->rsegments = $segments;
	}
	
	protected function _set_404override_controller()
	{
		$this->_set_module_path($this->routes['404_override']);
	}

	protected function _set_default_controller()
	{
		if (empty($this->directory))
		{
			/* set the default controller module path */
			$this->_set_module_path($this->default_controller);
		}

		parent::_set_default_controller();
		
		if(empty($this->class))
		{
			$this->_set_404override_controller();
		}
	}

	/** Locate the controller **/
	//updated by webhelios
	public function locate($segments) {		
		
		$this->module = '';
		$this->directory = '';
		$ext = $this->config->item('controller_suffix').EXT;
		
		/* use module route if available */
		if (isset($segments[0]) AND $routes = Modules::parse_routes($segments[0], implode('/', $segments))) {
			$segments = $routes;
		}
			
		if(isset($segments[0]) && $segments[0]=='admin')
		{
			$lang = 'en';
		}
		else
		{
			if(count($segments)>=2)
			{
				$lang = $segments[0];
				array_shift($segments);
			}
			else
			{			
	  		    $res = explode('/',$this->default_controller);
				$lang = $res[0];
				$segments = array($res[1]);
			}			
		}

		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);

		/* check modules */
		foreach (Modules::$locations as $location => $offset) {
		
			/* module exists? */
			if (is_dir($source = $location.$module.'/controllers/')) {
				
				$this->module = $module;
				$this->directory = $offset.$module.'/controllers/';
				

				/* module sub-controller exists? */
				if($directory AND is_file($source.ucfirst($directory).$ext)) {
					return array_slice($segments, 1);
				}
					
				/* module sub-directory exists? */
				if($directory AND is_dir($source.$directory.'/')) {

					$source = $source.$directory.'/'; 
					$this->directory .= $directory.'/';

					/* module sub-directory controller exists? */
					if(is_file($source.ucfirst($directory).$ext)) {
						return array_slice($segments, 1);
					}
				

					/* module sub-directory sub-controller exists? */
					if($controller AND is_file($source.ucfirst($controller).$ext))	{
						return array_slice($segments, 2);
					}
				}
				

				/* module controller exists? */			
				if(is_file($source.ucfirst($module).$ext)) {
					return $segments;
				}

				die;
			}
		}
		
		/* application controller exists? */			
		if (is_file(APPPATH.'controllers/'.ucfirst($module).$ext)) {
			return $segments;
		}
		
		/* application sub-directory controller exists? */
		if($directory AND is_file(APPPATH.'controllers/'.$module.'/'.ucfirst($directory).$ext)) {
			$this->directory = $module.'/';
			return array_slice($segments, 1);
		}
		
		/* application sub-directory default controller exists? */
		if (is_file(APPPATH.'controllers/'.$module.'/'.ucfirst($this->default_controller).$ext)) {
			$this->directory = $module.'/';
			return array($this->default_controller);
		}

		return array('404');
	}
	/* set module path */
	protected function _set_module_path(&$_route)
	{
		if ( ! empty($_route))
		{
			// Are module/directory/controller/method segments being specified?
			$sgs = sscanf($_route, '%[^/]/%[^/]/%[^/]/%s', $module, $directory, $class, $method);
			
			// set the module/controller directory location if found
			if ($this->locate(array($module, $directory, $class)))
			{
				//reset to class/method
				switch ($sgs)
				{
					case 1:	$_route = $module.'/index';
						break;
					case 2: $_route = ($this->located < 2) ? $module.'/'.$directory : $directory.'/index';
						break;
					case 3: $_route = ($this->located == 2) ? $directory.'/'.$class : $class.'/index';
						break;
					case 4: $_route = ($this->located == 3) ? $class.'/'.$method : $method.'/index';
						break;
				}
			}
		}
	}

	public function set_class($class)
	{
		$suffix = $this->config->item('controller_suffix');
		if (strpos($class, $suffix) === FALSE)
		{
			$class .= $suffix;
		}
		parent::set_class($class);
	}
}	