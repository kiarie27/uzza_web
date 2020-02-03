<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['blog_post_types']	= array('blog'=>'blog_post','article'=>'article','news'=>'news');


$config['decimal_point'] = '.';
$config['thousand_separator'] = ',';


#setting this config value to non empty will override the packge price currency.
#so if you have paypal enabled then remeber to use a currency which is supported by paypal. Otherwise your paypal payment will not work
#use this settings only if you want to enable bank payment and disable paypal payment
$config['package_currency'] = '';

#example
#$config['package_currency'] = 'USD';


#active languages 
$config['active_languages'] = array('en'=>'English','es'=>'Spanish','ru'=>'Russian','ar'=>'Arabic','de'=>'German','fr'=>'French','it'=>'Italian','pt'=>'Portuguese','zh'=>'Chinese (Simplified)','tr'=>'Turkish','hi'=>'Hindi','bn'=>'Bangla');
//$config['active_languages'] = array('en'=>'English');
$config['rtl_langs'] = array('ar','fa','he','ur');

#use ssl
$config['use_ssl'] = 'no';

#distance search slider settings
$config['min_distance'] = 1;
$config['max_distance'] = 500;
$config['default_distance'] = 25;


$config['sharethis_publisher_id'] = 'd866253d-fd08-403f-a8d1-bcd324c8163c'; // set your sharethis publisher id here

$config['send_notification_before_post_expiration'] = 'yes'; //set 'yes' or 'no'
$config['send_notification_before'] = 2; // no of days


$config['hide_report_car_link'] = 'No'; // set it 'Yes' if want to hide

$config['send_admin_email_user_signup'] = 'No'; // set 'Yes' if you want to send admin an email after each user signup
$config['send_email_after_post_published'] = 'No'; // set 'Yes' if you want to send users an email after their post get published

$config['search_url_separator'] = '+';
$config['plain_text_search_full_word_matching'] = 'No';//set it Yes or No

$config['skip_user_email_confirmation'] = 'No';//set it Yes or No