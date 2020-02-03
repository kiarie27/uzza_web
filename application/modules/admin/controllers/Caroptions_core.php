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


class Caroptions_core extends CI_Controller {
	
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

		$this->load->model('caroptions_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="margin:0">', '</div>');
	}
	
	public function index()
	{
		$this->all();
	}

	public function all($item='conditions',$start='0')

	{

        $data['title'] 		= lang_key($item);

        $value['posts'] 	= $this->caroptions_model->get_all_options_by_range($item,$start,$this->per_page,'name');


        if(!isset($value['posts']['error']))
        {
	        $total 				= $this->caroptions_model->get_all_options_by_range($item,'total');

			$value['pages']		= configPagination('admin/caroptions/all/'.$item,$total,6,$this->per_page);        	
        }

		$value['item']		= $item;

        $data['content'] 	= load_admin_view('caroptions/alloptions_view',$value,TRUE);

		load_admin_view('template/template_view',$data);		

	}

	public function create($item='conditions')

	{
		$value 			= array();
		$value['item']	= $item;
		load_admin_view('caroptions/createoption_view',$value);

	}

	public function save($item='conditions')

	{

		$this->form_validation->set_rules($item, lang_key($item), 'required');
		

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

				if($item=='cartypes')
				{
					$name = $this->input->post($item);
					$icon = $this->input->post('icon');

					$data_array = array();
					array_push($data_array, array('name'=>$name,'icon'=>$icon));
					$this->caroptions_model->insert_item($item,$data_array);
				}
				else
				{				
					$names = $this->input->post($item);

					$names_array = explode(',',$names);

					$this->caroptions_model->insert_item($item,$names_array);
				}

				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('option_added').'</div>');
			}

			redirect(site_url('admin/caroptions/create/'.$item));		

		}

	}

	public function edit($item='conditions',$id='')

	{

		$value['id'] 			= $id;
		$value['item'] 			= $item;

		$value['name'] 			= $this->caroptions_model->get_option_by_id($item,$id);
		load_admin_view('caroptions/edit_option_view',$value);

	}



	public function update($item='conditions')

	{

		$this->form_validation->set_rules($item, lang_key($item), 'required');
	
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

				if($item=='cartypes')
				{
					$name = $this->input->post($item);
					$icon = $this->input->post('icon');

					$data_array = array('name'=>$name,'icon'=>$icon);
					$this->caroptions_model->update_option_by_id($item,$id,$data_array);
				}
				else
				{

					$name = $this->input->post($item);

					$this->caroptions_model->update_option_by_id($item,$id,$name);
				}

				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('option_updated').'</div>');
			}

			redirect(site_url('admin/caroptions/edit/'.$item.'/'.$id));		

		}

	}


	#delete a brandmodel

	public function delete($page='0',$item='conditions',$id='',$confirmation='')

	{

		if($confirmation=='')

		{

			$data['content'] = load_admin_view('confirmation_view',array('id'=>$item.'/'.$id,'url'=>site_url('admin/caroptions/delete/'.$page)),TRUE);

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

					$this->caroptions_model->delete_option_by_id($item,$id);

					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('option_deleted').'</div>');
				}


			}

			redirect(site_url('admin/caroptions/all/'.$item.'/'.$page));		

			

		}		

	}


	public function icon_uploader()
	{
		 load_admin_view('caroptions/icon_uploader_view');
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