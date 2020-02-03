<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Carbiz admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Show
 * @subpackage	ShowModelCore
 * @author		webhelios
 * @link		http://webhelios.com
 */



class Show_model_core extends CI_Model 

{



	function __construct()

	{

		parent::__construct();

		$this->load->database();

	}



    function get_all_active_blog_posts_by_range($start,$limit='',$sort_by='',$sort='desc',$type="all")

    {

        if($type!='all')
            $this->db->where('type',$type);

        $this->db->order_by($sort_by, $sort);

        $this->db->where('status',1); 

        if($start==='all')

        {

            $query = $this->db->get('blog');

        }

        else

        {

            $query = $this->db->get('blog',$limit,$start);

        }

        return $query;

    }

    

    function count_all_active_blog_posts($type="all")

    {

        if($type!='all')
            $this->db->where('type',$type);

        $this->db->where('status',1);

        $query = $this->db->get('blog');

        return $query->num_rows();

    }


	function get_all_active_posts_by_range($start,$limit='',$sort_by='',$sort='desc')

	{

		$this->db->order_by($sort_by, $sort);

		$this->db->where('status',1); 

		if($start==='all')

		{

			$query = $this->db->get('posts');

		}

		else

		{

			$query = $this->db->get('posts',$limit,$start);

		}

		return $query;

	}

	

	function count_all_active_posts()

	{

		$this->db->where('status',1);

		$query = $this->db->get('posts');

		return $query->num_rows();

	}


	function get_all_user_active_posts_by_range($user_id='',$start,$limit='',$sort_by='',$sort='desc')

	{

		$this->db->order_by($sort_by, $sort);

		$this->db->where('status',1); 

		$this->db->where('created_by',$user_id);


		if($start==='all')

		{

			$query = $this->db->get('posts');

		}

		else

		{

			$query = $this->db->get('posts',$limit,$start);

		}

		return $query;

	}

	

	function count_all_user_active_posts($user_id='')

	{

		$this->db->where('status',1);
		$this->db->where('created_by',$user_id);

		$query = $this->db->get('posts');

		return $query->num_rows();

	}

    function get_latitude_longitude($address) {
	
		$address = trim($address);
		$address = str_replace(" ", "+", $address);
    	$details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=false";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $details_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($ch), true);
		curl_close($ch);
		// If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
		if ($response['status'] != 'OK') {
			return null;
		}
		$latLng = $response['results'][0]['geometry']['location'];
		return $latLng;
    }



    function get_advanced_search_result($data,$start = '0',$limit = '10') {

    	// echo '<pre>';
    	// print_r($data);
    	// die;
    	$min_price = get_settings('content_settings','min_car_price','NO');
		$max_price = get_settings('content_settings','max_car_price','NO');

		$distance_unit = get_settings('content_settings', 'show_distance_in', 'miles');

		$this->db->order_by('featured', 'desc');
		if(isset($data['sort_by']) && trim($data['sort_by'])!='') {
			$info = explode('_',$data['sort_by']);
			$this->db->order_by($info[0],$info[1]);
		}
		else
		{
			$this->db->order_by('id', "desc");
		}

		if(isset($data['country']) && $data['country']!='any' && $data['country']!='')
        {
            $this->db->where('country',$data['country']);
        }

        if(isset($data['state']) && $data['state']!='any' && $data['state']!='')
        {
            $this->db->where('state',$data['state']);
        }
        
        if(isset($data['city']) && $data['city']!='any' && $data['city']!='')
        {
            $this->db->where('city',$data['city']);
        }

        if(isset($data['category']) && trim($data['category'])!='any')
        {
        	$sql = "(category='".$data['category']."' or parent_category='".$data['category']."')";

            $this->db->where($sql);
           
        }

        if(isset($data['brand']) && !empty($data['brand']))
        {
	       $this->db->where('brand',$data['brand']);           
        }

        if(isset($data['model']) && !empty($data['model']))
        {
	       $this->db->where('model',$data['model']);           
        }

        if(isset($data['condition']) && !empty($data['condition']))
        {
	       $this->db->where('condition',$data['condition']);           
        }

        if(isset($data['fuel_type']) && !empty($data['fuel_type']))
        {
	       $this->db->where('fuel_type',$data['fuel_type']);           
        }

    	if(isset($data['mileage_min']) && trim($data['mileage_min'])!='') {
    		$this->db->where('mileage >=', $data['mileage_min']);
    	}
    	if(isset($data['mileage_max']) && trim($data['mileage_max'])!='') {
    		$this->db->where('mileage <=', $data['mileage_max']);
    	}

    	if(isset($data['price_min']) && trim($data['price_min'])!='' && $data['price_min']!=$min_price) {
    		$this->db->where('price >=', $data['price_min']);
    	}
    	if(isset($data['price_max']) && trim($data['price_max'])!='' && $data['price_max']!=$max_price) {
    		$this->db->where('price <=', $data['price_max']);
    	}

        $this->load->config('common');
        $full_word_matiching = $this->config->item('plain_text_search_full_word_matching');

        if(isset($data['plainkey']) && trim($data['plainkey'])!='') {

    		$search_string = rawurldecode($data['plainkey']);
    		$search_string = trim($search_string);
			$search_string = explode(" ", $search_string);

    		$sql = "";
    		$flag = 0;

    		foreach ($search_string as $key) {
				if($flag==0) {
					$flag = 1;
				}
				else {
					$sql .= "OR ";
				}

				if($full_word_matiching=='Yes')
				{
					$sql .= "search_meta RLIKE '".str_replace("'", "''", '[[:<:]]'.$this->db->escape_str($key).'[[:>:]]')."' "; //updatd on version 1.9					
					$this->db->where($sql, NULL, FALSE);					
				}
				else
				{
					$sql .= "search_meta LIKE '%".str_replace("'", "''", $key)."%' "; //updatd on version 1.9
					$this->db->where($sql);					
				}
			}
    	}

        if(isset($data['distance']) && $data['distance'] !=''
			&& isset($data['geo_lat']) && $data['geo_lat']!=''
			&& isset($data['geo_lng']) && $data['geo_lng'] !='')
        {

			$radius = (int)$data['distance'];
			$latitude = floatval($data['geo_lat']);
			$longitude = floatval($data['geo_lng']);



			$radius_in_kms = $distance_unit == 'miles' ? $radius * 1.60934 : $radius;

			$radius_condition = "(6371.0 * 2 * ASIN(SQRT(POWER(SIN((".$latitude." - latitude) * PI() / 180 / 2), 2) + COS(".$latitude." * PI() / 180)
                                    * COS(latitude * PI() / 180) * POWER(SIN((".$longitude." - longitude) * PI() / 180 / 2), 2))) <= ".$radius_in_kms.")";

			$this->db->where($radius_condition);
		}

		$this->db->where('status',1);

		


        if($start==='all')
        {
            $query = $this->db->get('posts');
        }
        elseif($start==='total')
        {
            $query = $this->db->get('posts');
            return $query->num_rows();
        }
        else
    	   $query = $this->db->get('posts',$limit,$start);

        // echo $this->db->last_query();
        // die;
	    return $query;

    }


	function get_post_by_unique_id($unique_id)

	{

		$query = $this->db->get_where('posts',array('unique_id'=>$unique_id));

		return $query;

	}



	function get_page_by_alias($alias)

    {

    	$query = $this->db->get_where('pages',array('alias'=>$alias));

    	return $query;

    }



    function get_alias_by_url($url)

    {

    	$query = $this->db->get_where('pages',array('content_from'=>'Url','url'=>$url));

    	if($query->num_rows()>0)

    	{

    		$row = $query->row();

    		return $row->alias;

    	}

    	else

    		return '';

    }



    function get_page_by_url($url)

    {

    	$query = $this->db->get_where('pages',array('url'=>$url,'status'=>1));

    	return $query;

    }



    function get_user_by_userid($user_id)

    {

    	$query = $this->db->get_where('users',array('id'=>$user_id));

    	return $query;

    }


    function get_user_row_by_userid($user_id)

    {

    	$query = $this->db->get_where('users',array('id'=>$user_id));

    	return $query->row();

    }



    function get_users_by_range($start,$limit='',$sort_by='id',$sort='desc')

    {
        if($this->input->post('agent_key')!='')
        {
            $key = $this->input->post('agent_key');
            $this->db->like('first_name',$key);
            $this->db->or_like('last_name',$key);
            $this->db->or_like('user_email',$key);
        }

        $this->db->order_by($sort_by, $sort);

        $this->db->where('status',1);

        if($start==='all')

        {

            $query = $this->db->get('users');

        }
        elseif($start==='total')

        {

            $query = $this->db->get('users');
            return $query->num_rows();
        }
        else

        {

            $query = $this->db->get('users',$limit,$start);

        }

        return $query;

    }

	function get_location_id_by_name($name,$type)
	{
		$this->db->where(array('status'=>1,'type'=>$type));
		$this->db->like('name', $name); 
		$query = $this->db->get('locations');
        $ids = array();
		if($query->num_rows()>0)
		{
			// $row = $query->row();
			// return $row->id;
            foreach ($query->result() as $row) {
                $ids[] = $row->id;
            }
            return $ids;
		}
		else
		{
			return '';
		}
	}

	function get_country_name_by_id($id)
	{
		$query = $this->db->get_where('locations',array('id'=>$id));
		if($query->num_rows()<=0)
		{
			return '';
		}
		else
		{
			return $query->row()->name;
		}
	}

	function get_locations_json($term='',$type,$parent)
	{

		$state_active = get_settings('content_settings', 'show_state_province', 'yes');
		$this->db->like('name',$term);
		if($state_active == 'yes')
		{
			$query = $this->db->get_where('locations',array('status'=>1,'type'=>$type,'parent'=>$parent));
		}
		else
		{
			$query = $this->db->get_where('locations',array('status'=>1,'type'=>$type,'parent_country'=>$parent));
		}

		$data = array();
		foreach ($query->result() as $row) {
			$val = array();
			$val['id'] = $row->id;
			$val['label'] = lang_key($row->name);
			$val['value'] = trim($row->name);
			array_push($data,$val);
		}
		return $data;
	}

}



/* End of file install.php */

/* Location: ./application/modules/show/models/show_model_core.php */