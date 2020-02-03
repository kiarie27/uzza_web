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


class Customfields_core extends CI_Controller {
	
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

		//$this->per_page = get_per_page_value();#defined in auth helper
		$this->per_page = 'all';#defined in auth helper

		$this->load->model('customfields_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="margin:0">', '</div>');
	}
	
	public function index()
	{
		$this->all();
	}

	public function all($start='0')

	{

        $data['title'] 		= lang_key('customfields');

        $value['posts'] 	= $this->customfields_model->get_all_customfields_by_range($start,$this->per_page,'sort_order');

      	if($this->per_page!='all')
      	{
	        $total 				= $this->customfields_model->get_all_customfields_by_range('total');

			$value['pages']		= configPagination('admin/customfields/all',$total,5,$this->per_page);        	      		
      	}

        $data['content'] 	= load_admin_view('customfields/allcustomfields_view',$value,TRUE);

		load_admin_view('template/template_view',$data);		

	}

	public function create()

	{
		$value 			= array();
		$this->load->model('admin/category_model');
		$value['categories'] = $this->category_model->get_all_parent_categories_by_range();
		load_admin_view('customfields/createcustomfield_view',$value);

	}

	public function save()

	{

		$this->form_validation->set_rules('fieldname', lang_key('fieldname'), 'required');
		$this->form_validation->set_rules('fieldtype', lang_key('fieldtype'), 'required');

		if ($this->form_validation->run() == FALSE)

		{

			$this->create();	

		}

		else

		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{

				$data = array();
				$data['name']			=	$this->input->post('fieldname');
				$data['type']			=	$this->input->post('fieldtype');
				$data['category_id']	=	$this->input->post('category_id');
				$data['options']		=	$this->input->post('options');
				$data['is_required']	=	$this->input->post('is_required');
				$data['help_text']		=	$this->input->post('help_text');
				$data['show_in_detail']	=	$this->input->post('show_in_detail');
				$data['show_in_search']	=	$this->input->post('show_in_search');
				$data['sort_order']		= 	999;

				$this->customfields_model->insert_data($data);
			
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('field_added').'</div>');
			}

			redirect(site_url('admin/customfields/create'));		

		}

	}

	public function edit($id='')

	{
		$value = array();
		$value['id'] 			= $id;
		$this->load->model('admin/category_model');
		$value['categories'] = $this->category_model->get_all_parent_categories_by_range();
		$value['post'] 			= $this->customfields_model->get_customfield_by_id($id);
		load_admin_view('customfields/edit_customfield_view',$value);

	}



	public function update()

	{

		$this->form_validation->set_rules('fieldname', lang_key('fieldname'), 'required');
		$this->form_validation->set_rules('fieldtype', lang_key('fieldtype'), 'required');
	
		$id = $this->input->post('id');



		if ($this->form_validation->run() == FALSE)

		{

			$this->edit($id);	

		}

		else

		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{

				$data = array();
				$data['name']			=	$this->input->post('fieldname');
				$data['type']			=	$this->input->post('fieldtype');
				$data['category_id']	=	$this->input->post('category_id');
				$data['options']		=	$this->input->post('options');
				$data['is_required']	=	$this->input->post('is_required');
				$data['help_text']		=	$this->input->post('help_text');
				$data['show_in_detail']	=	$this->input->post('show_in_detail');
				$data['show_in_search']	=	$this->input->post('show_in_search');

				$this->customfields_model->update_data($data,$id);
			
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('field_updated').'</div>');
			}

			redirect(site_url('admin/customfields/edit/'.$id));		

		}

	}


	#delete a brandmodel

	public function delete($page='0',$id='',$confirmation='')

	{

		if($confirmation=='')

		{

			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/customfields/delete/'.$page)),TRUE);

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

					$this->customfields_model->delete_data_by_id($id);

					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('field_deleted').'</div>');
				}


			}

			redirect(site_url('admin/customfields/all/'.$page));		

			

		}		

	}

	public function saveorder()
	{
		if(isset($_POST['id']) && is_array($_POST['id']))
		{
			$i = 1;
			foreach ($_POST['id'] as $id) {
				$data = array();
				$data['sort_order'] = $i;
				$this->customfields_model->update_data($data,$id);
				$i++;
			}
		}
		$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('field_order_updated').'</div>');
		redirect(site_url('admin/customfields/all'));
	}



	public function icon_uploader()
	{
		 load_admin_view('customfields/icon_uploader_view');
	}
	

	public function upload_icon()
	{
		
		$config['upload_path'] = './uploads/car-icons/';
		$config['allowed_types'] = 'gif|jpg|JPG|png';
		$config['max_size'] = '5120';
		
		$this->load->library('Upload', $config);
		$this->upload->display_errors('', '');

		if($this->upload->do_upload('photoimg'))
		{
			$data = $this->upload->data();
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'uploads/car-icons/'.$data['file_name'];
			$media['create_time'] 		= standard_date($format, $time);
			$media['status']			= 1;
			
			//create_square_thumb('./uploads/profile_photos/'.$data['file_name'],'./uploads/profile_photos/thumb/');

			$status['error'] 	= 0;
			$status['name']	= $data['file_name'];
		}
		else
		{
			$errors = $this->upload->display_errors();
			$errors = str_replace('<p>','',$errors);
			$errors = str_replace('</p>','',$errors);
			$status = array('error'=>$errors,'name'=>'');
		}
		echo json_encode($status);
		die;
	}
	
}

/* End of file admin.php */
/* Location: ./application/modules/admin/controllers/admin.php */