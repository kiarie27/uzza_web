<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<?php require_once'includes_top.php';?>
<style type="text/css">
    @media print {
        a[href]:after {
            content: none !important;
        }

        .no-print{
            display: none !important;
        }

        .new-page{
            page-break-after: always;
        }

    }
</style>
<script type="text/javascript">var base_url = '<?php echo base_url();?>';</script> <!-- added on version 1.5 -->


<link href="<?php echo theme_url();?>/assets/gallery/css/lightGallery.css" rel="stylesheet">
<script src="<?php echo theme_url();?>/assets/magnific/js/jquery.magnific-popup.min.js"></script>
<link href="<?php echo theme_url();?>/assets/magnific/css/magnific-popup.css" rel="stylesheet">
<?php
//added on version  1.7
$isSsl = (strpos('-'.base_url(), 'https://')>0)?'1':'0';
?>
<!-- Page heading two starts -->
<script src="<?php echo theme_url(); ?>/assets/gallery/js/jquery.lightSlider.min.js"></script>
<script src="<?php echo theme_url(); ?>/assets/gallery/js/lightGallery.min.js"></script>

<style>

    #details-map img { max-width: none; }
    .stButton .stFb, .stButton .stTwbutton, .stButton .stMainServices{
        height: 23px;
    }
    .stButton .stButton_gradient{
        height: 23px;
    }
    .map-wrapper{
        background: none repeat scroll 0 0 #f5f5f5;
        position: relative;
    }
    .map-wrapper #map_canvas_wrapper {
        overflow: hidden;
    }
    #map_street_view {
        height: 487px;
        width: 100%;
    }
    .car-title-detail a:hover{
        text-decoration: underline !important;
        color:#32C8DE !important;
    }
</style>
<?php 
$post = $post->row(); 
$detail_link = post_detail_url($post);
?>

<!-- Page heading two starts -->
<div class="page-heading-two">
    <div class="container">
        <div class="col-md-12">
            <h5 class="car-title-detail"><?php echo get_post_data_by_lang($post,'title'); ?> <span><a href="<?php echo site_url('show/categoryposts/'.$post->category.'/'.get_category_title_by_id($post->category));?>"><?php echo get_category_title_by_id($post->category); ?></a></span></h5>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Page heading two ends -->
<div class="container real-estate" style="padding-top: 10px">

    <!-- Actual content -->
    <div class="rs-property">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <!-- Nav tab style 1 starts -->
                <div class="nav-tabs-one">
                    <!-- Nav tabs -->
                    <!-- Tab content -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="p-nav-1">

                            <div class="single-property">

                                <?php $i=0; $images = ($post->gallery!='')?json_decode($post->gallery):array();?>

                                <div class="detail-slider" style="text-align:center">
                                                                        
                                        <img  src="<?php echo base_url().'uploads/images/'.$post->featured_img?>" style="width:35%" />
                                                                         
                                </div>

                                <div class="info-box">
                                    <?php
                                        $cat_info = get_category_title_icon_by_id($post->category);
                                        $fa_icon        = get_car_type_icon("link",$cat_info['icon']);
                                        $category_title = get_category_title_by_id($post->category);
                                    ?>
                                    <div class="sub-cat">
                                        <a href="<?php echo site_url('show/categoryposts/'.$post->category.'/'.$category_title);?>"><?php echo $category_title; ?></a>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-clock-o bg-red"></i> <?php echo lang_key('added'); ?>:</span>

                                        <span class="span-right">
                                                <?php 
                                                echo translatedDate($post->create_time);
                                                ?>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-money bg-yellow"></i> <?php echo lang_key('price'); ?>:</span>

                                        <span class="span-right">
                                                <?php echo show_price($post->price,$post->ask_for_price);?>
                                        </span>
                                    </div>


                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-diamond bg-green"></i> <?php echo lang_key('brand_model'); ?>:</span>

                                        <span class="span-right">
                                                <?php echo get_brand_model_name_by_id($post->brand).' '.get_brand_model_name_by_id($post->model);?>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-calendar-check-o bg-lblue"></i> <?php echo lang_key('year'); ?>:</span>

                                        <span class="span-right">
                                                <?php echo $post->year;?>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-tachometer bg-purple"></i> <?php echo lang_key('mileage'); ?>:</span>

                                        <span class="span-right">
                                                <?php echo $post->mileage.' '.$this->session->userdata('mileage_unit');?>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-cogs bg-red"></i> <?php echo lang_key('transmission'); ?>:</span>

                                        <span class="span-right">
                                                <?php echo lang_key($post->transmission);?>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-flask bg-orange"></i> <?php echo lang_key('fuel_type'); ?>:</span>

                                        <span class="span-right">
                                               <?php echo lang_key($post->fuel_type);?>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-map-marker bg-blue "></i> <?php echo lang_key('location'); ?>:</span>

                                        <span class="span-right">
                                                <a href="<?php echo site_url('location-posts/'.$post->city.'/city/'.dbc_url_title(get_location_name_by_id($post->city)));?>"><?php echo get_location_name_by_id($post->city); ?></a>
                                        </span>
                                    </div>



                                    <?php if($post->hide_email!=1){?>
                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-envelope bg-rose price-icon"></i> <?php echo lang_key('email'); ?>:</span>

                                        <span class="span-right">
                                                <a href="mailto:<?php echo $post->email; ?>" target="_top"><?php echo $post->email; ?></a>
                                        </span>
                                    </div>
                                    <?php }?>



                                    <?php if($post->hide_phone!=1){?>
                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-phone bg-brown phone-icon"></i> <?php echo lang_key('phone'); ?>:</span>

                                        <span class="span-right phone-num">
                                                <a href="tel: <?php echo $post->phone_no; ?>">
                                                <?php echo $post->phone_no; ?>
                                                </a>
                                        </span>
                                    </div>
                                    <?php }?>


                                    <?php if(get_settings('content_settings','enable_review','Yes')=='Yes'){?>
                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-star bg-yellow price-icon"></i> <?php echo lang_key('review'); ?>:</span>

                                        <span class="span-right">
                                         <?php 
                                          $average_rating = $post->rating; 
                                          $half_star_position = check_half_star_position($average_rating); 
                                          $reviews_array = get_all_post_reviews($post->id); 
                                            ?>
                                            <a href="<?php echo $detail_link;?>#review">
                                            <?php echo get_review_with_half_stars($average_rating,$half_star_position);?>
                                            </a>
                                            <?php echo $average_rating;?>/(<?php echo $reviews_array->num_rows().' '.lang_key('votes');?>)
                                        </span>
                                    </div>
                                    <?php }?>



                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-eye bg-purple view-icon"></i> <?php echo lang_key('views'); ?>:</span>

                                        <span class="span-right">
                                                <?php echo $post->total_view; ?>
                                        </span>
                                    </div>

                                    <?php if($post->featured==1){?>
                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-bookmark bg-orange"></i> <?php echo lang_key('featured'); ?>:</span>

                                        <span class="span-right">
                                                <?php echo lang_key('yes'); ?>
                                        </span>
                                    </div>
                                    <?php }?>

                                </div>
                                <div class="clearfix"></div>




                                <!-- heading -->
                                <h4 class="info-subtitle"><i class="fa fa-tasks"></i> <?php echo lang_key('description') ?></h4>

                                <!-- paragraph -->
                               <p><?php echo str_replace('href=', 'rel="nofollow" href=',get_post_data_by_lang($post,'description')); ?></p>
                                <hr />
                                <div class="clearfix"></div>
                                

                                <!-- heading -->
                                <h4 class="info-subtitle"><i class="fa fa-puzzle-piece"></i> <?php echo lang_key('other_information') ?></h4>

                                <!-- paragraph -->
                                <p>
                                <?php 
                                $custom_data = get_post_meta($post->id,'custom_data','[]');
                                $custom_data = (array)json_decode($custom_data);
                                echo '<ul class="custom-data-list">';
                                foreach ($fields->result() as $field) {
                                    if($field->show_in_detail==1){
                                        $value = (empty($custom_data[$field->name]))?lang_key('NA'):lang_key($custom_data[$field->name]);
                                        echo '<li><span class="span-left">'.lang_key($field->name).':</span><span class="span-right">'.$value.'</span><div class="clearfix"></div></li>';                                
                                    }
                                }
                                echo '<ul>';
                                ?>
                                </p>

                                <div class="clearfix"></div>
                                
                                <hr/>


                                <?php 

                                $address = get_post_data_by_lang($post,"address");

                                $full_address = get_formatted_address($address, $post->city, $post->state, $post->country, $post->zip_code); 

                                ?>
                                <div id="ad-address"><span><?php echo $full_address; ?></span></div>

                                <div class="clearfix"></div>


                            </div>
                        </div>

                        <div class="tab-pane fade" id="p-nav-2">

                            <div class="single-property sp-agent">
                                <!--img class="img-responsive img-thumbnail" src="<?php echo get_profile_photo_by_id($post->created_by); ?>" alt="" />
                                <h5><?php echo get_user_fullname_by_id($post->created_by); ?></h5-->

                                <!--span><strong><?php echo lang_key('contact_mode'); ?></strong>: <?php echo lang_key('phone'); ?>, <?php echo lang_key('email'); ?></span-->

                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th><?php echo lang_key('address'); ?></th>
                                            <td><?php echo $full_address; ?></td>
                                        </tr>
                                        <?php if(get_post_meta($post->id,'hide_my_email','')!=1){?>
                                        <tr>
                                            <th><?php echo lang_key('email'); ?></th>
                                            <td><?php echo $post->email; ?></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if(get_post_meta($post->id,'hide_my_phone','')!=1){?>
                                        <tr>
                                            <th><?php echo lang_key('phone'); ?></th>
                                            <td><?php echo $post->phone_no; ?></td>
                                        </tr>
                                        <?php }?>
                                    </table>
                                </div>

                                <?php if(get_post_meta($post->id,'disable_email_contact','')!=1){?>
                                <div class="rs-enquiry">
                                    <h3><?php echo lang_key('send_email_to_owner');?></h3>
                                    <div class="ajax-loading recent-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>
                                    <div class="clearfix"></div>
                                    <span class="agent-email-form-holder">
                                    </span>
                                </div>
                                <?php }?>

                            </div>

                        </div>

                        <?php if(get_settings('content_settings','enable_review','Yes')=='Yes'){?>
                         <div class="tab-pane fade" id="p-nav-3">
                             <div class="ajax-loading review-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>

                             <?php if(is_loggedin()){?>

                             <span class="review-form-holder"></span>
                            <?php } else { ?>
                                 <div class="alert alert-info" role="alert"><?php echo lang_key('review_alert'); ?></div>
                             <?php } ?>
                             <div style="margin-top:20px"></div>
                             <h4 class="info-subtitle"><i class="fa fa-rocket"></i> <?php echo lang_key('recent_reviews');?></h4>
                             <div id="reviews-holder" class="team-two">
                                 <?php require('all_reviews_view.php');?>
                             </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>


<?php
// added on version 1.6
$map_api_key = get_settings('banner_settings','map_api_key','');
$api_key_text = ($map_api_key!='')?"&key=$map_api_key":'';
$lang = get_current_lang();//added on version 1.9
?>
<script src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places<?php echo $api_key_text;?>&language=<?php echo $lang;?>"></script>
<script src="<?php echo theme_url();?>/assets/map/js/markercluster.min.js"></script>
<script src="<?php echo theme_url();?>/assets/map/js/map-icons.min.js"></script>
<script src="<?php echo theme_url();?>/assets/map/js/map_config.js"></script>

<script type="text/javascript">

    $(document).ready(function() {
        setTimeout(function(){
          window.print();
          window.close();  
        }, 2000);
           
    });


    // added on version 1.5
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    var isSsl = '<?php echo $isSsl;?>';

</script>

