<link href="<?php echo theme_url();?>/assets/gallery/css/lightGallery.css" rel="stylesheet">
<script src="<?php echo theme_url();?>/assets/magnific/js/jquery.magnific-popup.min.js"></script>
<link href="<?php echo theme_url();?>/assets/magnific/css/magnific-popup.css" rel="stylesheet">
<?php
//added on version  1.7
$isSsl = (strpos('-'.base_url(), 'https://')>0)?'1':'0';
?>
<script type="text/javascript">
    var switchTo5x=true;
    var pub_id = '<?php echo ($this->config->item("sharethis_publisher_id")!="")?$this->config->item("sharethis_publisher_id"):"d866253d-fd08-403f-a8d1-bcd324c8163c"?>';
    <?php if($isSsl){?>
    var url = "//ws.sharethis.com/button/buttons.js";
    <?php }else{?>
    var url = "//w.sharethis.com/button/buttons.js";
    <?php }?>    
    $.getScript( url, function() {
        stLight.options({publisher: pub_id, doNotHash: false, doNotCopy: true, hashAddressBar: false});
    });
</script>
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
        <div class="col-md-7">
	        <h5 class="car-title-detail"><?php echo get_post_data_by_lang($post,'title'); ?> <span><a href="<?php echo site_url('show/categoryposts/'.$post->category.'/'.get_category_title_by_id($post->category));?>"><?php echo get_category_title_by_id($post->category); ?></a></span></h5>
        </div>
        <div class="col-md-5">
        <div class="breads detail-page-breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('car_detail'); ?>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Page heading two ends -->
<div class="container real-estate" style="padding-top: 10px">

    <!-- Actual content -->
    <div class="rs-property">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">

                <!-- Nav tab style 1 starts -->
                <div class="nav-tabs-one">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#p-nav-1" data-toggle="tab"><?php echo lang_key('details'); ?></a></li>
                        <li><a href="#p-nav-2" data-toggle="tab"><?php echo lang_key('contact'); ?></a></li>
                        <?php if(get_settings('content_settings','enable_review','Yes')=='Yes'){?>
                        <li class="review-tab"><a href="#p-nav-3" data-toggle="tab"><?php echo lang_key('review'); ?></a></li>
                        <?php }?>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="p-nav-1">

                            <div class="single-property">

                                <?php $i=0; $images = ($post->gallery!='')?json_decode($post->gallery):array();?>

                                <div class="detail-slider">
                                    <ul id="imageGallery">
                                        <?php
                                        if($post->featured_img=='')
                                        {
                                        ?>
                                        <li data-thumb="<?php echo base_url().'assets/admin/img/preview.jpg';?>" data-src="<?php echo base_url().'assets/admin/img/preview.jpg';?>">
                                            <span class="helper"></span><img  src="<?php echo base_url().'assets/admin/img/preview.jpg';?>" />
                                        </li>
                                        <?php
                                        }else{
                                        ?>
                                        <li data-thumb="<?php echo base_url().'uploads/images/'.$post->featured_img?>" data-src="<?php echo base_url().'uploads/images/'.$post->featured_img?>">
                                            <span class="helper"></span><img  src="<?php echo base_url().'uploads/images/'.$post->featured_img?>" />
                                        </li>
                                        <?php
                                        }
                                        ?>
                                        <?php $i=0; $images = ($post->gallery!='')?json_decode($post->gallery):array();?>
                                        <?php
                                        if(count($images)>0 && $images[0]!='')
                                        {
                                            foreach ($images as $img)
                                            {
                                        ?>
                                        <li data-thumb="<?php echo base_url('uploads/gallery/' . $img); ?>" data-src="<?php echo base_url('uploads/gallery/' . $img); ?>">
                                            <span class="helper"></span><img  src="<?php echo base_url('uploads/gallery/' . $img); ?>" />
                                        </li>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </ul>
                                </div>
                                <div class="clearfix"></div>

                                <hr />
                                <div class="info-box">
                                    <?php
                                        $cat_info = get_category_title_icon_by_id($post->category);
                                        $fa_icon        = get_car_type_icon("link",$cat_info['icon']);
                                        $category_title = get_category_title_by_id($post->category);
                                    ?>
                                    <i class="bg-red category"><img src="<?php echo $fa_icon;?>" class="map-marker" /></i>
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

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-file-word-o bg-red"></i> <?php echo lang_key('brochure'); ?>:</span>

                                        <span class="span-right">
                                                <a target="_blank" href="<?php echo base_url('uploads/brochure/'.$post->brochure);?>"><?php echo $post->brochure; ?></a>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-right">
                                        <a target="_blank" href="<?php echo site_url('show/printview/'.$post->unique_id);?>"><i class="fa fa-print fa-lg"></i> <?php echo lang_key('print') ?></a></span>
                                    </div>
                                    <div class="share-links">
                                        <span class='st_sharethis_hcount' displayText='<?php echo lang_key('share_this');?>'></span>
                                        <span class='st_facebook_hcount' displayText='Facebook'></span>
                                        <span class='st_twitter_hcount' displayText='Tweet'></span>
                                        <span class='st_linkedin_hcount' displayText='LinkedIn'></span>
                                        <span class='st_pinterest_hcount' displayText='Pinterest'></span>
                                        <span class='st_email_hcount' displayText='Email'></span>
                                    </div>
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

                                <h4 class="info-subtitle"><i class="fa fa-map-marker"></i> <?php echo lang_key('location_on_map'); ?></h4>
                                <div class="gmap" id="details-map"></div>
                                <div id="dir-panel"></div><!-- added on version 1.8 -->
                                <div class="clearfix"></div>
                                <a href="javascript:void(0);" onclick="calcRoute()" class="pull-right btn btn-primary" style="width:100%"><?php echo lang_key('get_directions'); ?></a>
                                <div class="clearfix"></div>


                                <?php
                                $comment_settings = get_settings('content_settings', 'enable_comment', 'No');
                                if($comment_settings == 'Disqus Comment')
                                {
                                    $disqus_shortname = get_settings('content_settings', 'disqus_shortname', 'notfound');

                                ?>
                                <div id="disqus_thread"></div>
                                <script type="text/javascript">
                                    var disqus_shortname = '<?php echo $disqus_shortname; ?>'; // required: replace example with your forum shortname

                                    (function() {
                                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                    })();
                                </script>
                                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                <div class="clearfix"></div>

                                <?php
                                }
                                ?>

                                <?php

                                if($comment_settings == 'Facebook Comment')
                                {
                                    $fb_app_id = get_settings('content_settings', 'fb_comment_app_id', ''); ?>
                                    <style>
                                        .fb-comments, .fb-comments iframe[style] {width: 100% !important;}
                                    </style>
                                    <div id="fb-root"></div>
                                    <script>
                                        var fb_app_id = '<?php echo $fb_app_id; ?>';

                                        (function(d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0];
                                            if (d.getElementById(id)) return;
                                            js = d.createElement(s); js.id = id;
                                            js.src = "//connect.facebook.net/<?php echo get_current_lang().'_'.strtoupper(get_current_lang());?>/sdk.js#xfbml=1&appId=" + fb_app_id + "&version=v2.0";
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));
                                    </script>

                                    <div style="clear:both;margin-top:10px;"></div>
                                    <div class="fb-comments" data-href=" <?php echo current_url();?>" data-numposts="10" data-colorscheme="light"></div>

                                <?php
                                }
                                ?>
                                <?php if($post->video_url !=''){?>
                                <h4 class="info-subtitle"><i class="fa fa-film"></i> <?php echo lang_key('featured_video'); ?></h4>
                                    <span id="video_preview"></span>

                                    <input type="hidden" name="video_url" id="video_url" value="<?php echo $post->video_url;?>">
                                <?php }?>
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
                                        <?php if($post->hide_email!=1){?>
                                        <tr>
                                            <th><?php echo lang_key('email'); ?></th>
                                            <td><?php echo $post->email; ?></td>
                                        </tr>
                                        <?php } ?>

                                        <?php if($post->hide_phone!=1){?>
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
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="sidebar">

                    <div class="s-widget">
                        <h5><i class="fa fa-photo color"></i>&nbsp; <?php echo lang_key('image_gallery'); ?></h5>
                        <div class="widget-content gallery">
                            <?php if($post->featured_img==''){?>
                            <div class="thumb">
                                <a href="<?php echo base_url().'assets/admin/img/preview.jpg';?>" class="lightbox">
                                <img src="<?php echo base_url().'assets/admin/img/preview.jpg';?>" alt="" class="img-responsive " />
                                </a>
                            </div>
                            <?php }else{?>
                            <div class="thumb">
                                <a href="<?php echo base_url('uploads/images/' . $post->featured_img); ?>" class="lightbox">
                                <img src="<?php echo base_url('uploads/images/' . $post->featured_img); ?>" alt="" class="img-responsive " />
                                </a>
                            </div>
                            <?php 
                            }
                            ?>
                            <?php foreach ($images as $img) { ?>
                            <div class="thumb">
                                <a href="<?php echo base_url('uploads/gallery/' . $img); ?>" class="lightbox">
                                <img src="<?php echo base_url('uploads/gallery/' . $img); ?>" alt="" class="img-responsive " />
                                </a>
                            </div>
                            <?php $i++; } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="s-widget">
                        <h5><i class="fa fa-tags color"></i>&nbsp; <?php echo lang_key('tags'); ?></h5>
                        <?php
                        $tags = $post->tags;
                        $CI = get_instance();
                        $CI->load->helper('text');
                        ?>
                        <?php if($tags != 'n/a' && $tags != ''){ ?>
                            <div class="widget-content tags">
                                <?php $tags = explode(',',$tags);
                                foreach ($tags as $tag) { ?>
                                    <a class="label label-color" href="<?php echo site_url('show/results/plainkey='.$tag)?>"><?php echo character_limiter($tag,30,'...'); ?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>                
                    <?php render_widgets('right_bar_detail');?>
                    <div class="clearfix"></div>
                    <?php if($this->config->item('hide_report_car_link')!='Yes'){?>
                        <div class="s-widget">
                            <i class="fa fa-flag color"></i>&nbsp; <a class="js-report" type="button" href="<?php echo site_url('user/reportpost/'.$post->id)?>"><?php echo lang_key('report_the_car');?></a>
                        </div>
                    <?php }?>

                </div>
            </div>
        </div>
    </div>
</div>

</div>

<div id="reviewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel"><?php echo lang_key('review'); ?></h4>

            </div>

            <div class="modal-body">


            </div>

            <div class="modal-footer">

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
    function getUrlVars(url) {

        var vars = {};

        var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {

            vars[key] = value;

        });

        return vars;

    }



    function showVideoPreview(url)

    {

        if(url.search("youtube.com")!=-1)

        {

            var video_id = getUrlVars(url)["v"];

            //https://www.youtube.com/watch?v=jIL0ze6_GIY

            var src = '//www.youtube.com/embed/'+video_id;

            //var src  = url.replace("watch?v=","embed/");

            var code = '<iframe class="thumbnail" width="100%" height="420" src="'+src+'" frameborder="0" allowfullscreen></iframe>';

            jQuery('#video_preview').html(code);

        }

        else if(url.search("vimeo.com")!=-1)

        {

            //http://vimeo.com/64547919

            var segments = url.split("/");

            var length = segments.length;

            length--;

            var video_id = segments[length];

            var src  = url.replace("vimeo.com","player.vimeo.com/video");

            var code = '<iframe class="thumbnail" src="//player.vimeo.com/video/'+video_id+'" width="100%" height="420" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

            jQuery('#video_preview').html(code);

        }

        else

        {


        }

    }

    $(document).ready(function() {
    	$('.lightbox').magnificPopup({type:'image'});
    	
        jQuery('.review-detail').click(function(e){
            e.preventDefault();
            var loadUrl = jQuery(this).attr('href');
            jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    jQuery('#reviewModal .modal-body').html(responseText);
                    jQuery('#reviewModal').modal('show');
                }
            );

        });

        jQuery('#video_url').change(function(){

            var url = jQuery(this).val();

            showVideoPreview(url);

        }).change();

             
    });

    //added on version 1.9
    $(function() {
        function imageLoaded() {
           counter--; 
           if( counter === 0 ) {
            <?php
            $CI = get_instance();
            $curr_lang = get_current_lang();
            if($curr_lang=='ar' || $curr_lang=='fa' || $curr_lang=='he' || $curr_lang=='ur')
            {
            ?>
            var rtl = true;
            <?php }else{?>
            var rtl = false;
            <?php }?>

            $('#imageGallery').lightSlider({
                gallery:false,
                item:1,
                speed:1000,
                pause:3000,
                rtl:rtl,
                auto:true,
                loop: true,
                thumbItem:9,
                slideMargin:0,
                currentPagerPosition:'left',
                onSliderLoad: function(plugin) {
                    plugin.lightGallery();

                }
            }); 

           }
        }
        var images = $('.gallery img');
        var counter = images.length;  // initialize the counter

        images.each(function() {
            if( this.complete ) {
                imageLoaded.call( this );
            } else {
                $(this).one('load', imageLoaded);
            }
        });
    });
    
    //end

    var myLatitude = parseFloat('<?php echo $post->latitude; ?>');

    var myLongitude = parseFloat('<?php echo $post->longitude; ?>');

    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();


    function initialize() {

        directionsDisplay = new google.maps.DirectionsRenderer();

        var zoomLevel = parseInt('<?php echo get_settings('banner_settings','map_zoom',8); ?>');

        var myLatlng = new google.maps.LatLng(myLatitude,myLongitude);
        var map_data = <?php echo get_car_map_data_single($post); ?>;

        var mapOptions = {
            scrollwheel: false,
            zoom: zoomLevel,
            center: myLatlng,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            panControl: true,
            panControlOptions: {
                position: google.maps.ControlPosition.RIGHT_TOP
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: MAP_STYLE
        }
        map = new google.maps.Map(document.getElementById('details-map'), mapOptions);

         directionsDisplay.setMap(map);
         // added on version 1.8
         directionsDisplay.setPanel(document.getElementById('dir-panel'));


        var contentString = '<div class="clearfix"></div>'+
                            '<div class="infowindow-container">'+
                                '<div class="info-image-holder">'+
                                    '<img src="'+map_data.posts[0].featured_image_url+'">'+
                                '</div>'+
                                '<div class="detail-holder">'+
                                    '<h4>'+map_data.posts[0].post_title+'</h4>'+
                                    '<div class="infowindow-category">'+map_data.posts[0].parent_category+'</div>'+
                                    '<div class="infowindow-price"><?php echo lang_key("price");?>: '+map_data.posts[0].price+'</div>'+
                                    '<a href="'+map_data.posts[0].detail_link+'" class="infowindow-detail-link"><?php echo lang_key("detail");?></a>'+
                                '</div>'+
                                '<div style="clear:both"></div>'+
                            '</div>';


        var infowindow = new google.maps.InfoWindow({

            content: contentString

        });

        var marker, i;

        var markers = [];

        marker = new Marker({

            position: myLatlng,

            map: map,

            title: '<?php echo addslashes(get_post_data_by_lang($post,"title")); ?>',
            zIndex: 9,
            icon: {
                path: SQUARE_PIN,
                fillColor: '#ed5441',
                fillOpacity: 1,
                strokeColor: '',
                strokeWeight: 0,
                scale: 1/3
            },
            map_icon_label: '<img src="<?php echo $fa_icon; ?>" class="map-marker"/>'


        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {

            return function() {

                infowindow.open(map, marker);

            }

        })(marker, i));

        markers.push(marker);

        if (window.location.href.indexOf("#review") > -1) {
            jQuery('.review-tab a').trigger('click');
        }

    }

    // added on version 1.5
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    var isSsl = '<?php echo $isSsl;?>';

    function calcRoute() {

        if(isChrome==true && isSsl==0)
        {
            var r = confirm("<?php echo lang_key('location_chorome_msg')?>");
            if(r==true)
            {
                $.get("//ipinfo.io", function(response) {
                var arr = response.loc.split(",");

                        var lat = arr[0];
                        var lng = arr[1];


                        var geolocate = new google.maps.LatLng(lat, lng);

                        var start = geolocate;
                        var end = new google.maps.LatLng(myLatitude,myLongitude);
                        var request = {
                            origin:start,
                            destination:end,
                            travelMode: google.maps.TravelMode.DRIVING
                        };
                        directionsService.route(request, function(response, status) {
                            if (status == google.maps.DirectionsStatus.OK) {
                                directionsDisplay.setDirections(response);
                            }
                        });


                }, "jsonp");
                
            }
        }
        else
        {
            if(!!navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(position) {

                    var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                    var start = geolocate;
                    var end = new google.maps.LatLng(myLatitude,myLongitude);
                    var request = {
                        origin:start,
                        destination:end,
                        travelMode: google.maps.TravelMode.DRIVING
                    };
                    directionsService.route(request, function(response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                        }
                    });


                });

            } else {
                alert('No Geolocation Support.');
            }            
        }


        
    }
    //end



    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!-- Main content ends -->


<script src="<?php echo theme_url();?>/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){

    $("#reviews-holder").mCustomScrollbar();

    var loadUrl = '<?php echo site_url("show/load_contact_agent_view/".$post->unique_id);?>';
    jQuery.post(
        loadUrl,
        {},
        function(responseText){
            jQuery('.agent-email-form-holder').html(responseText);
            init_send_contact_email_js();
        }
    );

});



function init_send_contact_email_js()
{
        jQuery('#message-form').submit(function(e){
        var data = jQuery(this).serializeArray();
        jQuery('.recent-loading').show();
        e.preventDefault();
        var loadUrl = jQuery(this).attr('action');
        jQuery.post(
            loadUrl,
            data,
            function(responseText){
                jQuery('.agent-email-form-holder').html(responseText);
                jQuery('.alert-success').each(function(){
                    jQuery('#message-form input[type=text]').each(function(){
                        jQuery(this).val('');
                    });
                    jQuery('#message-form textarea').each(function(){
                        jQuery(this).val('');
                    });
                    jQuery('#message-form input[type=checkbox]').each(function(){
                        jQuery(this).attr('checked','');
                    });

                });
                jQuery('.recent-loading').hide();
                init_send_contact_email_js();
            }
        );
    });

}
</script>

<?php if(is_loggedin()){?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var loadUrl = '<?php echo site_url("show/review/load_review_form/".$post->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.review-form-holder').html(responseText);
                init_create_review_js();
            }
        );

        if (window.location.href.indexOf("#review") > -1) {
            jQuery('.review-tab a').trigger('click');
        }
    });

    function init_create_review_js()
    {
        jQuery('#review-form').submit(function(e){
            var data = jQuery(this).serializeArray();
            jQuery('.review-loading').show();
            e.preventDefault();
            var loadUrl = jQuery(this).attr('action');
            jQuery.post(
                loadUrl,
                data,
                function(responseText){
                    jQuery('.review-form-holder').html(responseText);
                    jQuery('.alert-success').each(function(){
                        jQuery('#review-form input[type=text]').each(function(){
                            jQuery(this).val('');
                        });
                        jQuery('#review-form textarea').each(function(){
                            jQuery(this).val('');
                        });
                    });

                    loadUrl = '<?php echo site_url("show/review/load_all_reviews/".$post->id);?>';
                    jQuery.post(
                        loadUrl,
                        {},
                        function(responseText){
                            jQuery('#mCSB_1_container').html(responseText);
                        }
                    );

                    jQuery('.review-loading').hide();
                    init_create_review_js();
                }
            );
        });

    }
</script>
<?php } ?>


<?php if($this->config->item('hide_report_car_link')!='Yes'){?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.js-report').on('click',function(e){
            e.preventDefault();
            var is_loggedin = '<?php echo (is_loggedin())?"yes":"no";?>';
            
            if(is_loggedin=='no')
            {
                <?php $this->session->set_userdata('req_url',current_url());?>
                jQuery('.signin').trigger('click');
            }
            else
            {
                var load_url = $('.js-report').attr('href');

                jQuery.post(
                    load_url,
                    {},
                    function(responseText){
                        if(responseText == 'TRUE')
                            jQuery('.js-report').html('<?php echo lang_key("reported")?>');
                        else
                            jQuery('.js-report').html('<?php echo lang_key("already_reported")?>');

                    }

                );                
            }
        });

    });
</script>
<?php }?>