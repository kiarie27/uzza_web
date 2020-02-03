<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Carbiz Customfields_model model
 *
 * This class handles Customfields_model management related functionality
 *
 * @package		Admin
 * @subpackage	Customfields_model
 * @author		webhelios
 * @link		http://webhelios.com
 */
class Customfields_model_core extends CI_Model 
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_all_customfields_by_range($start,$limit=20,$sort_by='sort_order')
	{
		$this->db->order_by($sort_by, "asc");
		$this->db->where('status',1); 

		$key = $this->input->post('key');
		if($key!='')
		{
			$this->db->like('name',$key);
		}

		if($start=='all')
		{			
			$query = $this->db->get('customfields');
			return $query;
		}
		elseif($start=='total')
		{
			$query = $this->db->get('customfields');
			return $query->num_rows();			
		}
		else
		{
			$this->db->limit($limit, $start);
			$query = $this->db->get('customfields');
			return $query;			
		}
	}

	function insert_data($data)
	{
		$this->db->insert('customfields',$data);
	}

	function get_customfield_by_id($id)
	{
		$query = $this->db->get_where('customfields',array('id'=>$id));
		return $query->row();
	}

	function update_data($data,$id)
	{
		$this->db->update('customfields',$data,array('id'=>$id));
	}	

	function delete_data_by_id($id)
	{
		$this->db->update('customfields',array('status'=>0),array('id'=>$id));
	}	
}

/* End of file Customfields_model.php */
/* Location: ./system/application/models/Customfields_model.php */