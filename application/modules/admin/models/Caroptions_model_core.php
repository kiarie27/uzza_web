<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Carbiz category_model_core model
 *
 * This class handles category_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	category_model_core
 * @author		webhelios
 * @link		http://webhelios.com
 */
class Caroptions_model_core extends CI_Model 
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_all_options_by_range($item,$start,$limit=20)
	{
		$options = get_option($item);

		if(!empty($options->values))
		{
			$data_array = (array)json_decode($options->values);

			$search_key = $this->input->post('key');
			if($search_key!='')
			{
				foreach ($data_array as $key => $value) {

					if($item=='cartypes')
					{
						// echo $value->name."#".$search_key."<br/>";
						if(stripos('#'.$value->name, $search_key)<=0)
							unset($data_array[$key]);
					}
					else
					{
						if(stripos('#'.$value, $search_key)<=0)
							unset($data_array[$key]);
					}
				}
			}

			if($start=='total')
			{
				return count($data_array); 
			}
			if($start=='all')
			{
				return $data_array;
			}
			else
			{
				$data_array = array_slice($data_array, $start, $limit);
				return (array)$data_array;
			}
		}
		else
			return array('error'=>'empty value');

	}

	function insert_item($item,$data)
	{
		$ready_data = $this->get_all_options_by_range($item,'all');
		if(!(isset($ready_data['error'])))
		{
			$data = array_merge($data,$ready_data);
		}
		add_option($item,json_encode($data));
	}

	function get_option_by_id($item,$id)
	{
		$data = $this->get_all_options_by_range($item,'all');
		return (isset($data[$id]))?$data[$id]:'0';
	}

	function update_option_by_id($item,$id,$info)
	{
		$data = $this->get_all_options_by_range($item,'all');
		$data[$id] = $info;		
		
		add_option($item,json_encode($data));
	}	

	function delete_option_by_id($item,$id)
	{
		$data = $this->get_all_options_by_range($item,'all');
		unset($data[$id]);		
		add_option($item,json_encode($data));
	}	
}

/* End of file category_model_core.php */
/* Location: ./system/application/models/category_model_core.php */