<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Carbiz Category Controller
 *
 * This class handles category management functionality
 *
 * @package		Admin
 * @subpackage	Category
 * @author		webhelios
 * @link		http://webhelios.com
 */


class Brandmodels_core extends CI_Controller {
	
	var $per_page = 10;
	
	public function __construct()
	{
		parent::__construct();
		is_installed(); #defined in auth helper
		checksavedlogin(); #defined in auth helper
		
		if(!is_admin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper

		$this->load->model('brandmodels_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="margin:0">', '</div>');
	}
	
	public function index()
	{
		$this->all();
	}

	public function all($start='0')

	{

        $data['title'] 		= lang_key('brandmodels');

        $value['posts'] 	= $this->brandmodels_model->get_all_brandmodels_by_range($start,$this->per_page,'name');

        $total 				= $this->brandmodels_model->count_all_brandmodels();

		$value['pages']		= configPagination('admin/brandmodels/all',$total,5,$this->per_page);



        $data['content'] = load_admin_view('brandmodels/all_brandmodels_view',$value,TRUE);

		load_admin_view('template/template_view',$data);		

	}

	



	public function newbrandmodel($type='brand')

	{

		$value['type'] = $type;

		$value['countries'] = $this->brandmodels_model->get_brandmodels_by_type('brand');

		$value['models'] 	= $this->brandmodels_model->get_brandmodels_by_type('model');

		load_admin_view('brandmodels/new_brandmodel_view',$value);

	}



	public function savebrandmodel()

	{

		$this->form_validation->set_rules('type', 'Type', 'required');

		$type = $this->input->post('type');

		if($type=='model')

		$this->form_validation->set_rules('brand', 'brand', 'required');


		

		$this->form_validation->set_rules('brandmodels', 'Names', 'required');

		

		if ($this->form_validation->run() == FALSE)

		{

			$this->newbrandmodel($type);	

		}

		else

		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{

				$brandmodels = $this->input->post('brandmodels');

				$brandmodels_array = explode(',',$brandmodels);

				if($type=='brand')

					$parent = 0;

				elseif($type=='model')

					$parent = $this->input->post('brand');




				foreach ($brandmodels_array as $brandmodel) 

				{

					$data = array();			

					$data['name'] 	= trim($brandmodel);

					$data['type'] 	= $type;

					$data['parent'] = $parent;

					$data['status']	= 1;

					$this->brandmodels_model->insert_brandmodels($data);

				}

				



				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data inserted</div>');
			}

			redirect(site_url('admin/brandmodels/newbrandmodel/'.$type));		

		}

	}



	public function editbrandmodel($type='brand',$id='')

	{

		$value['type'] = $type;

		$value['editbrandmodel'] 	= $this->brandmodels_model->get_brandmodels_by_id($id);

		$value['countries'] 	= $this->brandmodels_model->get_brandmodels_by_type('brand');

		$value['models'] 		= $this->brandmodels_model->get_brandmodels_by_type('model');

		load_admin_view('brandmodels/edit_brandmodel_view',$value);

	}



	public function updatebrandmodel()

	{

		$this->form_validation->set_rules('type', 'Type', 'required');

		$id = $this->input->post('id');

		$type = $this->input->post('type');

		if($type=='model')

		$this->form_validation->set_rules('brand', 'brand', 'required');


		

		$this->form_validation->set_rules('brandmodel', 'Name', 'required');

		

		if ($this->form_validation->run() == FALSE)

		{

			$this->editbrandmodel($type,$id);	

		}

		else

		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{

				if($type=='brand')

					$parent = 0;

				elseif($type=='model')

					$parent = $this->input->post('brand');




				$data = array();			

				$data['name'] 	= $this->input->post('brandmodel');

				$data['type'] 	= $type;

				$data['parent'] = $parent;

				$data['status']	= 1;

				$this->brandmodels_model->update_brandmodels($data,$id);

				



				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data Updated</div>');
			}

			redirect(site_url('admin/brandmodels/editbrandmodel/'.$type.'/'.$id));		

		}

	}



	#delete a brandmodel

	public function deletebrandmodel($page='0',$id='',$confirmation='')

	{

		if($confirmation=='')

		{

			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/brandmodels/deletebrandmodel/'.$page)),TRUE);

			load_admin_view('template/template_view',$data);

		}

		else

		{

			if($confirmation=='yes')

			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{

					$this->brandmodels_model->delete_brandmodels_by_id($id);

					$this->session->set_flashdata('msg', '<div class="alert alert-success">brandmodel Deleted</div>');
				}


			}

			redirect(site_url('admin/brandmodels/all/'.$page));		

			

		}		

	}


}

/* End of file admin.php */
/* Location: ./application/modules/admin/controllers/admin.php */