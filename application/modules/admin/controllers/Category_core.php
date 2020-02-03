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


class Category_core extends CI_Controller {
	
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

		$this->load->model('category_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="margin:0">', '</div>');
	}
	
	public function index()
	{
		$this->all();
	}

	#load all services view with paging
	public function all($start='0')
	{
		$value['posts']  	 = $this->category_model->get_all_categories_by_range($start,'id');

        $data['title'] = lang_key('all_categories');
        $data['content'] = load_admin_view('categories/allcategories_view',$value,TRUE);
		 load_admin_view('template/template_view',$data);		
	}

	#load new service view
	public function newcategory()
	{
        load_admin_view('categories/newcategory_view','');
	}
	
	#load edit service view
	public function edit($id='')
	{
		$value['post']  = $this->category_model->get_category_by_id($id);
		load_admin_view('categories/editcategory_view',$value);
	}
	
	#delete a service
	public function delete($id='',$confirmation='')
	{
		if($confirmation=='')
		{
			// added on version 1.6
			$category = $this->category_model->get_category_by_id($id);
			$info = '"'.$category->title.'"';
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/category/delete'),'info'=>$info),TRUE);
			load_admin_view('template/template_view',$data);
			// end
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
					$this->category_model->delete_category_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
				}
			}
			redirect(site_url('admin/category/all'));		
			
		}		
	}

	#add a service
	public function addcategory()
	{	
		$this->form_validation->set_rules('title', lang_key('title'), 'required');
		$this->form_validation->set_rules('featured_img', lang_key('featured_img'), 'required');					

		if ($this->form_validation->run() == FALSE)
		{
			$this->newcategory();	
		}
		else
		{
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data 					= array();			
			$data['title'] 			= $this->input->post('title');
			$data['parent'] 		= 0;
			$data['fa_icon'] 		= "fa-car";
			$data['featured_img'] 	= $this->input->post('featured_img');
			$data['create_time'] 	= $time;
			$data['created_by']		= get_id_by_username($this->session->userdata('user_name'));
			$data['status']			= 1;
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->category_model->insert_category($data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_inserted').'</div>');				
			}
			redirect(site_url('admin/category/newcategory'));		
		}
	}
	
	
	#update a service
	public function updatecategory()
	{
		$this->form_validation->set_rules('title', lang_key('title'), 'required');
		$this->form_validation->set_rules('featured_img', lang_key('featured_img'), 'required');			

		if ($this->form_validation->run() == FALSE)
		{
			$id = $this->input->post('id');
			$this->edit($id);	
		}
		else
		{
			$id = $this->input->post('id');

			$data 					= array();
			$data['title'] 			= $this->input->post('title');
			$data['parent'] 		= 0;
			$data['fa_icon'] 		= 'fa-car';
			$data['featured_img'] 	= $this->input->post('featured_img');
			$data['created_by'] 	= $this->session->userdata('user_id');
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->category_model->update_category($data,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/category/edit/'.$id));		
		}
	}

	public function featuredimguploader()

	{

		load_admin_view('categories/featured_img_uploader_view');

	}

	public function uploadfeaturedfile()
	{
		$dir_name 					= 'car-icons/';
		$config['upload_path'] 		= './uploads/'.$dir_name;
		$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
		$config['max_size'] 		= '5120';
		$config['min_width'] 		= '32';
		$config['min_height'] 		= '32';

		$this->load->library('upload', $config);
		$this->upload->display_errors('', '');

		if($this->upload->do_upload('photoimg'))
		{
			$data = $this->upload->data();
			$this->load->helper('date');

			$format = 'DATE_RFC822';
			$time = time();

			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'uploads/'.$dir_name.$data['file_name'];
			$media['create_time'] 		= standard_date($format, $time);
			$media['status']			= 1;

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