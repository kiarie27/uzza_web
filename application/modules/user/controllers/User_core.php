<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Carbiz admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		User
 * @subpackage	UserCore
 * @author		webhelios
 * @link		http://webhelios.com
 */

class User_core extends CI_Controller {
	
	var $active_theme = '';
	var $per_page = 2;
	public function __construct()
	{
		parent::__construct();
		is_installed(); #defined in auth helper
		
		if(!is_loggedin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('account/trylogin'));
		}
		
        $system_currency_type = get_settings('content_settings','system_currency_type',0);
        if($system_currency_type == 0)
        {
            $system_currency = get_currency_icon(get_settings('content_settings','system_currency','USD'));
        }
        else
        {
            $system_currency = get_settings('content_settings','system_currency','USD');
        }

        $this->session->set_userdata('system_currency',$system_currency);


		$this->per_page = get_per_page_value();

		$this->load->database();
		$this->active_theme = get_active_theme();
		$this->load->model('user/post_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger form-error">', '</div>');

	}
	
	public function index()
	{
		$this->post();	
	}

	function create_post_validation()
	{

	}

	function before_post_creation()
	{

	}	

	function after_post_creation($post_id)
	{
		if(get_settings('package_settings','enable_pricing','Yes')=='Yes' && $this->session->userdata('selected_package')=='' && is_admin()!=FALSE)
		{
			redirect(site_url('choose-package'));
			die;
		}
		else if(get_settings('package_settings','enable_pricing','Yes')=='Yes')
		{		
			$this->session->set_userdata('post_id',$post_id);
			redirect(site_url('user/payment/save_payment_history'));
		}
		else {
			if(get_settings('content_settings','publish_directly','Yes')=='Yes') {

				$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_created_and_published').'</div>');
			}
			else {

				$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_created_approval').'</div>');
			}
			redirect(site_url('edit-car/0/'.$post_id));
		}
	}

	function update_post_validation()
	{

	}

	function before_post_update()
	{

	}	

	function after_post_update($post_id)
	{

	}

	public function new_ad($msg='')
	{
		if(get_settings('package_settings','enable_pricing','Yes')=='Yes' && $this->session->userdata('selected_package')=='')
		{
			redirect(site_url('choose-package'));
			die;
		}

		$value = array();
		$value['categories'] = $this->post_model->get_all_categories();
		
		$this->load->model('admin/customfields_model');
		$value['fields'] 	 = $this->customfields_model->get_all_customfields_by_range("all");

		$this->load->model('admin/brandmodels_model');
		$value['brands'] 	 = $this->brandmodels_model->get_brandmodels_by_type('brand');
		$value['models'] 	 = $this->brandmodels_model->get_brandmodels_by_type('model'); 

		$this->load->model('admin/caroptions_model');
		$value['transmissions']	 = $this->caroptions_model->get_all_options_by_range('transmissions','all','','name');
		$value['conditions'] 	 = $this->caroptions_model->get_all_options_by_range('conditions','all','','name');
		$value['fueltypes'] 	 = $this->caroptions_model->get_all_options_by_range('fueltypes','all','','name');


		$data['content'] 	 = load_view('post_ad_view',$value,TRUE);
		load_template($data,$this->active_theme);
	}

	public function urlslug_check($str)
	{
		$id  = $this->input->post('id');
		$this->load->model('user/post_model');
		$res = $this->post_model->check_url_slug($str,$id);

		if (!$res)
		{
			$this->form_validation->set_message('urlslug_check', lang_key('url_slug_must_be_unique'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function create_ad()
	{
		$state_active = get_settings('content_settings', 'show_state_province', 'yes');

		$this->form_validation->set_rules('url_slug', 		lang_key('url_slug'), 		'required|callback_urlslug_check');
		$this->form_validation->set_rules('category', 		lang_key('category'), 		'required');
		$this->form_validation->set_rules('brand', 			lang_key('brand'), 			'required');
		$this->form_validation->set_rules('model', 			lang_key('model'), 			'xss_clean');
		$this->form_validation->set_rules('year', 			lang_key('year'), 			'required');
		$this->form_validation->set_rules('mileage', 		lang_key('mileage'), 		'required');
		$this->form_validation->set_rules('transmission', 	lang_key('transmission'), 	'required');
		$this->form_validation->set_rules('condition', 		lang_key('condition'), 		'required');
		$this->form_validation->set_rules('fuel_type', 		lang_key('fuel_type'), 		'required');
		$this->form_validation->set_rules('phone_no', 		lang_key('phone'), 			'required');
		$this->form_validation->set_rules('email', 			lang_key('email'), 			'required');
		$this->form_validation->set_rules('country', 		lang_key('country'), 			'required');
		if($state_active == 'yes')
		$this->form_validation->set_rules('state', 			lang_key('state'), 				'required');
		$this->form_validation->set_rules('selected_city', 	lang_key('city'), 				'xss_clean');
		$this->form_validation->set_rules('city', 			lang_key('city'), 				'required');
		$this->form_validation->set_rules('zip_code', 		lang_key('zip_code'), 			'xss_clean');
		$this->form_validation->set_rules('latitude', 		lang_key('latitude'), 			'required');
		$this->form_validation->set_rules('longitude', 		lang_key('longitude'), 			'required');

		$this->form_validation->set_rules('title_'.get_current_lang(), 				lang_key('title'), 				'required');
		$this->form_validation->set_rules('address_'.get_current_lang(), 			lang_key('address'), 				'required');		
		$this->form_validation->set_rules('description_'.get_current_lang(), 		lang_key('description'), 		'required');

		if($this->input->post('ask_for_price')==1)		
		$this->form_validation->set_rules('price', 			lang_key('price'), 		'xss_clean');
		else
		$this->form_validation->set_rules('price', 			lang_key('price'), 		'required|xss_clean');

		$this->form_validation->set_rules('tags', 			lang_key('tags'), 		'xss_clean');
		$this->form_validation->set_rules('brochure', 		lang_key('brochure'), 	'xss_clean');

		$this->load->model('admin/customfields_model');
		$custom_fields 	 = $this->customfields_model->get_all_customfields_by_range("all");
		foreach ($custom_fields->result() as $field) {
			if($field->is_required==1)
			{
				if(!empty($field->category_id) && $this->input->post('category')==$field->category_id)
					$this->form_validation->set_rules($field->name, lang_key($field->name), 'required|xss_clean');
				else if(!empty($field->category_id) && $this->input->post('category')!=$field->category_id)
					$this->form_validation->set_rules($field->name, lang_key($field->name), 'xss_clean');
				else
					$this->form_validation->set_rules($field->name, lang_key($field->name), 'required|xss_clean');
			}
			else
			{
				$this->form_validation->set_rules($field->name, lang_key($field->name), 'xss_clean');
			}
		}

		$this->create_post_validation();
		
		if ($this->form_validation->run() == FALSE)
		{
			$msg = '<div class="alert alert-danger form-error">'.lang_key('ad_creation_error').'</div>';
			$this->new_ad($msg);	
		}
		else
		{
			$meta_search_text = '';		//meta information for simple searching

			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data 						= array();		
			$data['unique_id']			= $this->input->post('url_slug');	


			$data['category'] 			= $this->input->post('category');
			$meta_search_text 		   .= get_category_title_by_id($data['category']).' ';


			$data['price'] 						= $this->input->post('price');
			$data['phone_no'] 					= $this->input->post('phone_no');
			$data['hide_phone'] 				= ($this->input->post('hide_phone')==null)?0:1;
			$data['email'] 						= $this->input->post('email');
			$data['hide_email'] 				= ($this->input->post('hide_email')==null)?0:1;
			$data['disable_email_contact'] 		= ($this->input->post('disable_email_contact')==null)?0:1;
			$data['brand'] 						= $this->input->post('brand');
			$data['model'] 						= $this->input->post('model');
			$data['year'] 						= $this->input->post('year');
			$data['price'] 						= $this->input->post('price');
			$data['ask_for_price'] 				= ($this->input->post('ask_for_price')==null)?0:1;
			$data['mileage'] 					= $this->input->post('mileage');
			$data['transmission'] 				= $this->input->post('transmission');
			$data['condition'] 					= $this->input->post('condition');
			$data['fuel_type'] 					= $this->input->post('fuel_type');


			$data['country'] 			= $this->input->post('country');
			$meta_search_text 		   .= get_location_name_by_id($data['country']).' ';

			$data['state'] 				= $state_active == 'yes' ? $this->input->post('state') : 0;
			$meta_search_text 		   .= get_location_name_by_id($data['state']).' ';

			$selected_city = $this->input->post('selected_city');
			$city = $this->input->post('city');
			if($selected_city == '')
			{
				$new_city_id = $this->post_model->get_location_id_by_name($city, 'city', $data['state'], $data['country']);
			}
			else
			{
				$new_city_id = $selected_city;
			}

			$data['city'] 				= $new_city_id;
			$meta_search_text .= get_location_name_by_id($data['city']).' ';

			$data['zip_code'] 			= $this->input->post('zip_code');
			$meta_search_text .= $data['zip_code'].' ';


			$data['latitude'] 			= $this->input->post('latitude');
			$data['longitude'] 			= $this->input->post('longitude');

			$this->load->model('admin/system_model');
            $langs = $this->system_model->get_all_langs();
            $titles = array();
            $descriptions = array();
            $addresses = array();

            foreach ($langs as $lang=>$long_name)
            { 
            	$titles[$lang] = $this->input->post('title_'.$lang);
            	$addresses[$lang] = $this->input->post('address_'.$lang);
				$meta_search_text .= $titles[$lang].' ';
				$meta_search_text .= $addresses[$lang].' ';

            	$descriptions[$lang] = $this->input->post('description_'.$lang);
            }  


            if (version_compare(PHP_VERSION, '5.4.0') >= 0) 
			{
				$data['title'] 			= json_encode($titles,JSON_UNESCAPED_UNICODE);
				$data['description'] 	= json_encode($descriptions,JSON_UNESCAPED_UNICODE);
				$data['address'] 		= json_encode($addresses,JSON_UNESCAPED_UNICODE);
			}
			else
			{
				$data['title'] 			= json_encode($titles);
				$data['description'] 	= json_encode($descriptions);
				$data['address'] 		= json_encode($addresses);				
			}
			
			$data['tags'] 				 = $this->input->post('tags');
			$meta_search_text			.=  $data['tags'].' ';

			$data['featured_img'] 		= $this->input->post('featured_img');
			$data['video_url'] 			= $this->input->post('video_url');
			$data['brochure'] 			= $this->input->post('brochure');
			$data['gallery'] 			= ($this->input->post('gallery')!=false)?json_encode($this->input->post('gallery')):'[]';

			if($this->input->post('assigned_to')!='')
			$data['created_by'] 		= $this->input->post('assigned_to');


			$data['created_by']			= $this->session->userdata('user_id');
			$data['create_time'] 		= $time;
			$data['publish_time'] 		= $time;
			$data['last_update_time'] 	= $time;
			
			$publish_directly 			= get_settings('content_settings','publish_directly','Yes');
			$enable_pricing				= get_settings('package_settings','enable_pricing','Yes');
			
			/**************************

				status=0: post is deleted
				status=1: post is active
				status=2: post requires admin approval
				status=3: post requires payment
				status=4: post is expired
	
			**************************/

			if($enable_pricing=='Yes') {
				$data['status'] = 3;
			}
			else {

				$data['status']	= ($publish_directly=='Yes' || is_admin())?1:2; // 2 = pending //updated on version 1.8
			}
			
			$data['featured'] 			= 0;
			$data['report'] 			= 0;
			$data['total_view'] 		= 0;
			$data['total_view'] 		= 0;
			$data['search_meta'] = $meta_search_text;

			$this->before_post_creation();

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$post_id = $this->post_model->insert_post($data);
			
				$custom_data = array();
				foreach ($custom_fields->result() as $field) {
					$custom_data[$field->name] = $this->input->post($field->name);
				}
	
				if (version_compare(PHP_VERSION, '5.4.0') >= 0) 
				{
					add_post_meta($post_id,'custom_data',json_encode($custom_data,JSON_UNESCAPED_UNICODE));
				}
				else
				{
					add_post_meta($post_id,'custom_data',json_encode($custom_data));
				}

				
				$this->after_post_creation($post_id);

				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('ad_created').'</div>');
			}
			redirect(site_url('post-ad'));
		}
	}

	function checkpermission($id)
	{
		$post = $this->post_model->get_post_by_id($id);
		if($post->num_rows()>0)
		{

			$row = $post->row();

			if(is_admin())
				return TRUE;
			else if($this->session->userdata('user_id')==$row->created_by)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	public function editpost($page='0',$id='')
	{
		if(!$this->checkpermission($id))
		{
			$this->session->set_flashdata('<div class="alert alert-danger">'.lang_key('dont_have_permission').'</div>');
			redirect(site_url('admin/content/allposts'));
		}

		$value = array();
		$value['categories'] = $this->post_model->get_all_categories();
		
		$this->load->model('admin/customfields_model');
		$value['fields'] 	 = $this->customfields_model->get_all_customfields_by_range("all");

		$this->load->model('admin/brandmodels_model');
		$value['brands'] 	 = $this->brandmodels_model->get_brandmodels_by_type('brand');
		$value['models'] 	 = $this->brandmodels_model->get_brandmodels_by_type('model'); 

		$this->load->model('admin/caroptions_model');
		$value['transmissions']	 = $this->caroptions_model->get_all_options_by_range('transmissions','all','','name');
		$value['conditions'] 	 = $this->caroptions_model->get_all_options_by_range('conditions','all','','name');
		$value['fueltypes'] 	 = $this->caroptions_model->get_all_options_by_range('fueltypes','all','','name');


		$value['post']			= $this->post_model->get_post_by_id($id);
		$value['page']			= $page;
		$data['content'] 		= load_view('edit_ad_view',$value,TRUE);
		load_template($data,$this->active_theme);
	}

	public function updatepost()
	{
		$state_active = get_settings('content_settings', 'show_state_province', 'yes');
		$id 	= $this->input->post('id');
		$page 	= $this->input->post('page');

		if(!$this->checkpermission($id))
		{
			$this->session->set_flashdata('<div class="alert alert-danger">'.lang_key('dont_have_permission').'</div>');
			redirect(site_url('admin/content/allposts'));
		}

		$this->form_validation->set_rules('url_slug', 		lang_key('url_slug'), 		'required|callback_urlslug_check');
		$this->form_validation->set_rules('category', 		lang_key('category'), 		'required');
		$this->form_validation->set_rules('brand', 			lang_key('brand'), 			'required');
		$this->form_validation->set_rules('model', 			lang_key('model'), 			'required');
		$this->form_validation->set_rules('year', 			lang_key('year'), 			'required');
		$this->form_validation->set_rules('mileage', 		lang_key('mileage'), 		'required');
		$this->form_validation->set_rules('transmission', 	lang_key('transmission'), 	'required');
		$this->form_validation->set_rules('condition', 		lang_key('condition'), 		'required');
		$this->form_validation->set_rules('fuel_type', 		lang_key('fuel_type'), 		'required');
		$this->form_validation->set_rules('phone_no', 		lang_key('phone'), 			'required');
		$this->form_validation->set_rules('email', 			lang_key('email'), 			'required');
		$this->form_validation->set_rules('country', 		lang_key('country'), 			'required');
		if($state_active == 'yes')
		$this->form_validation->set_rules('state', 			lang_key('state'), 				'required');
		$this->form_validation->set_rules('selected_city', 	lang_key('city'), 				'xss_clean');
		$this->form_validation->set_rules('city', 			lang_key('city'), 				'required');
		$this->form_validation->set_rules('zip_code', 		lang_key('zip_code'), 			'xss_clean');
		$this->form_validation->set_rules('latitude', 		lang_key('latitude'), 			'required');
		$this->form_validation->set_rules('longitude', 		lang_key('longitude'), 			'required');

		$this->form_validation->set_rules('title_'.get_current_lang(), 				lang_key('title'), 				'required');
		$this->form_validation->set_rules('address_'.get_current_lang(), 			lang_key('address'), 				'required');		
		$this->form_validation->set_rules('description_'.get_current_lang(), 		lang_key('description'), 		'required');
		
		if($this->input->post('ask_for_price')==1)
			$this->form_validation->set_rules('price', 			lang_key('price'), 		'xss_clean');
		else
			$this->form_validation->set_rules('price', 			lang_key('price'), 		'required|xss_clean');
		
		$this->form_validation->set_rules('tags', 			lang_key('tags'), 		'xss_clean');
		$this->form_validation->set_rules('brochure', 		lang_key('brochure'), 	'xss_clean');

		$this->load->model('admin/customfields_model');
		$custom_fields 	 = $this->customfields_model->get_all_customfields_by_range("all");
		foreach ($custom_fields->result() as $field) {
			if($field->is_required==1)
			{
				if(!empty($field->category_id) && $this->input->post('category')==$field->category_id)
					$this->form_validation->set_rules($field->name, lang_key($field->name), 'required|xss_clean');
				else if(!empty($field->category_id) && $this->input->post('category')!=$field->category_id)
					$this->form_validation->set_rules($field->name, lang_key($field->name), 'xss_clean');
				else
					$this->form_validation->set_rules($field->name, lang_key($field->name), 'required|xss_clean');
			}
			else
			{
				$this->form_validation->set_rules($field->name, lang_key($field->name), 'xss_clean');
			}
		}

		$this->update_post_validation();

		if ($this->form_validation->run() == FALSE)
		{
			$this->editpost($page,$id);	
		}
		else
		{
			$meta_search_text = '';		//meta information for simple searching

			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data 						= array();		
			$data['unique_id']			= $this->input->post('url_slug');	


			$data['category'] 			= $this->input->post('category');
			$meta_search_text 		   .= get_category_title_by_id($data['category']).' ';


			$data['price'] 						= $this->input->post('price');
			$data['phone_no'] 					= $this->input->post('phone_no');
			$data['hide_phone'] 				= ($this->input->post('hide_phone')==null)?0:1;
			$data['email'] 						= $this->input->post('email');
			$data['hide_email'] 				= ($this->input->post('hide_email')==null)?0:1;
			$data['disable_email_contact'] 		= ($this->input->post('disable_email_contact')==null)?0:1;
			$data['brand'] 						= $this->input->post('brand');
			$data['model'] 						= $this->input->post('model');
			$data['year'] 						= $this->input->post('year');
			$data['price'] 						= $this->input->post('price');
			$data['ask_for_price'] 				= ($this->input->post('ask_for_price')==null)?0:1;
			$data['mileage'] 					= $this->input->post('mileage');
			$data['transmission'] 				= $this->input->post('transmission');
			$data['condition'] 					= $this->input->post('condition');
			$data['fuel_type'] 					= $this->input->post('fuel_type');


			$data['country'] 			= $this->input->post('country');
			$meta_search_text 		   .= get_location_name_by_id($data['country']).' ';

			$data['state'] 				= $state_active == 'yes' ? $this->input->post('state') : 0;
			$meta_search_text 		   .= get_location_name_by_id($data['state']).' ';

			$selected_city = $this->input->post('selected_city');
			$city = $this->input->post('city');
			if($selected_city == '')
			{
				$new_city_id = $this->post_model->get_location_id_by_name($city, 'city', $data['state'], $data['country']);
			}
			else
			{
				$new_city_id = $selected_city;
			}

			$data['city'] 				= $new_city_id;
			$meta_search_text .= get_location_name_by_id($data['city']).' ';

			$data['zip_code'] 			= $this->input->post('zip_code');
			$meta_search_text .= $data['zip_code'].' ';


			$data['latitude'] 			= $this->input->post('latitude');
			$data['longitude'] 			= $this->input->post('longitude');

			$this->load->model('admin/system_model');
            $langs = $this->system_model->get_all_langs();
            $titles = array();
            $descriptions = array();
            $addresses = array();

            foreach ($langs as $lang=>$long_name)
            { 
            	$titles[$lang] = $this->input->post('title_'.$lang);
            	$addresses[$lang] = $this->input->post('address_'.$lang);
				$meta_search_text .= $titles[$lang].' ';
				$meta_search_text .= $addresses[$lang].' ';

            	$descriptions[$lang] = $this->input->post('description_'.$lang);
            }  


            if (version_compare(PHP_VERSION, '5.4.0') >= 0) 
			{
				$data['title'] 			= json_encode($titles,JSON_UNESCAPED_UNICODE);
				$data['description'] 	= json_encode($descriptions,JSON_UNESCAPED_UNICODE);
				$data['address'] 		= json_encode($addresses,JSON_UNESCAPED_UNICODE);
			}
			else
			{
				$data['title'] 			= json_encode($titles);
				$data['description'] 	= json_encode($descriptions);
				$data['address'] 		= json_encode($addresses);				
			}
			
			$data['tags'] 				 = $this->input->post('tags');
			$meta_search_text			.=  $data['tags'].' ';

			$data['featured_img'] 		= $this->input->post('featured_img');
			$data['video_url'] 			= $this->input->post('video_url');
			$data['brochure'] 			= $this->input->post('brochure');
			$data['gallery'] 			= ($this->input->post('gallery')!=false)?json_encode($this->input->post('gallery')):'[]';

			if($this->input->post('assigned_to')!='')
			$data['created_by'] 		= $this->input->post('assigned_to');

			$data['last_update_time'] 	= $time;
			$data['search_meta'] 		= $meta_search_text;

			$this->before_post_update();

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$post_id = $id;
				$this->post_model->update_post($data,$id);

				$custom_data = array();
				foreach ($custom_fields->result() as $field) {
					$custom_data[$field->name] = $this->input->post($field->name);
				}
	
				if (version_compare(PHP_VERSION, '5.4.0') >= 0) 
				{
					add_post_meta($post_id,'custom_data',json_encode($custom_data,JSON_UNESCAPED_UNICODE));
				}
				else
				{
					add_post_meta($post_id,'custom_data',json_encode($custom_data));
				}

				$this->after_post_update($post_id);

				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('post_updated').'</div>');
			}
			redirect(site_url('edit-car/'.$page.'/'.$id));
		}
	}

	public function uploadfeaturedfile()
    {
    	$max_upload_size = get_settings('content_settings','max_upload_file_size',5120);
        $dir_name 					= 'images/';
        $config['upload_path'] 		= './uploads/'.$dir_name;
        $config['allowed_types'] 	= 'gif|jpg|png|jpeg';
        $config['max_size'] 		= $max_upload_size;
        $config['min_width'] 		= '300';
        $config['min_height'] 		= '256';

        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');

        if($this->upload->do_upload('photoimg'))
        {

            $data = $this->upload->data();
            $this->load->helper('date');
            $format = 'DATE_RFC822';
            $time = time();
            create_rectangle_thumb('./uploads/'.$dir_name.$data['file_name'],'./uploads/thumbs/');
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
            $status = array('error'=>lang_key($errors),'name'=>'');
        }

        echo json_encode($status);
        die;
    }

    public function upload_brochurefile()
    {
    	$max_upload_size = get_settings('content_settings','max_upload_file_size',5120);
        $dir_name 					= 'brochure/';
        $config['upload_path'] 		= './uploads/'.$dir_name;
        $config['allowed_types'] 	= 'doc|docx|pdf|txt|xls|xlsx|csv|gif|jpg|png|jpeg';
        $config['max_size'] 		= $max_upload_size;
        // $config['min_width'] 		= '300';
        // $config['max_height'] 		= '70';

        $this->load->library('upload', $config);
        $this->upload->display_errors('', '');

        if($this->upload->do_upload('photoimg'))
        {

            $data = $this->upload->data();
            $this->load->helper('date');
            $format = 'DATE_RFC822';
            $time = time();
            //create_rectangle_thumb('./uploads/'.$dir_name.$data['file_name'],'./uploads/thumbs/');
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

    public function uploadgalleryfile()
	{
		$max_upload_size = get_settings('content_settings','max_upload_file_size',5120);
		$config['upload_path'] = './uploads/gallery/';
		$config['allowed_types'] = 'gif|jpg|jpeg|JPG|png';
		$config['max_size'] = $max_upload_size;

		$this->load->library('upload', $config);
		$this->upload->display_errors('', '');	

		if($this->upload->do_upload('photoimg'))
		{

			$data = $this->upload->data();
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'uploads/gallery/'.$data['file_name'];
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

    public function reportpost($post_id=''){

        $report_response = $this->post_model->report_post($post_id);

        if($report_response == 'TRUE'){
            echo 'TRUE';
        }
        else{
            echo 'FALSE';
        }

    }





}

/* End of file install.php */
/* Location: ./application/modules/user/controllers/user_core.php */