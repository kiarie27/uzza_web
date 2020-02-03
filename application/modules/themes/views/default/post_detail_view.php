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
<?php
if(count($blogpost)<=0){

}else{
?>
<div class="page-heading-two">
    <div class="container">
        <div class="col-md-7">
            <h5><?php echo get_blog_data_by_lang($blogpost,'title'); ?></h5>
        </div>
        <div class="col-md-5">
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo get_blog_data_by_lang($blogpost,'title'); ?>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php
}
?>

<!-- Container -->
<div class="container">

    <div class="blog-two">
        <div class="row">

            <div class="col-md-9 col-sm-12 col-xs-12">
                <?php

                if(count($blogpost)<=0){

                    ?>

                    <div class="alert alert-danger"><?php echo lang_key('post_not_found'); ?></div>

                <?php
                }else{ ?>
                    <!-- Blog item starts -->
                    <div class="blog-two-item">
                        <!-- blog two Content -->
                        <div class="blog-two-content">
                            <!-- Blog meta -->
                            <div class="blog-meta">
                                <!-- Date -->
                                <i class="fa fa-calendar"></i> &nbsp; <?php echo translatedDate($blogpost->create_time);?> &nbsp;<!-- updated on version 1.6 -->
                                <!-- Author -->
                                <i class="fa fa-user"></i> &nbsp; <?php echo get_user_fullname_by_id($blogpost->created_by); ?> &nbsp;

                            </div>

                                                        
                            <!-- Paragraph -->
                            <p>
                                <img src="<?php echo base_url('uploads/images/' . $blogpost->featured_img); ?>" class="blog-image" alt="">
                                <?php echo get_blog_data_by_lang($blogpost,'description');?>
                            </p>
                        </div>
                    </div>
                    <!-- Blog item ends -->
                    <!-- Social media sharing section -->
                    <div class="well">
                        <span class='st_sharethis_large' displayText='ShareThis'></span>
                        <span class='st_facebook_large' displayText='Facebook'></span>
                        <span class='st_twitter_large' displayText='Tweet'></span>
                        <span class='st_linkedin_large' displayText='LinkedIn'></span>
                        <span class='st_pinterest_large' displayText='Pinterest'></span>
                        <span class='st_email_large' displayText='Email'></span>

                    </div>


            <div class="agent-holder clearfix">
                <!-- Team #2 -->
                <div class="team-two">
                    <div class="row">
                       
                            <!-- Team #2 member -->
                           <div class="col-md-2 col-sm-2 col-xs-12">
                                <!-- Image -->
                                <a href="<?php echo site_url('profile/'.$blogpost->created_by.'/'.get_user_fullname_by_id($blogpost->created_by));?>">
                                <img class="img-responsive user-photo-list" src="<?php echo get_profile_photo_by_id($blogpost->created_by,'thumb');?>" alt="" />

                                </a>

                            </div>
                            
                            <div class="col-md-9 col-sm-9 col-xs-12">    
                                <div class="team-details">
                                    <!-- Name -->
                                    <h4><?php echo get_user_fullname_by_id($blogpost->created_by)?></h4>
                                    <?php if(get_user_meta($blogpost->created_by, 'company_name')!=''){?>
                                        <p class="contact-types">
                                            <strong><?php echo lang_key('company_name'); ?>:</strong> <?php echo get_user_meta($blogpost->created_by, 'company_name'); ?></a>
                                        </p>
                                    <?php }?>
                                    <?php if(get_user_meta($blogpost->created_by, 'about_me')!=''){?>
                                    <!-- Para -->
                                    <p><?php echo get_user_meta($blogpost->created_by, 'about_me'); ?></p>
                                    <?php }?>                                    
                                    <!-- Social -->
                                    <?php $fb_profile = get_user_meta($blogpost->created_by, 'fb_profile'); ?>
                                    <?php $gp_profile = get_user_meta($blogpost->created_by, 'gp_profile'); ?>
                                    <?php $twitter_profile = get_user_meta($blogpost->created_by, 'twitter_profile'); ?>
                                    <?php $li_profile = get_user_meta($blogpost->created_by, 'li_profile'); ?>
                                    <div class="brand-bg member-social-links">
                                        <?php if($fb_profile != ''){?>
                                        <a class="facebook" href="https://<?php echo $fb_profile; ?>"><i class="fa fa-facebook circle-3"></i></a>
                                        <?php }?>
                                        <?php if($gp_profile != ''){?>
                                        <a class="google-plus" href="https://<?php echo $gp_profile; ?>"><i class="fa fa-google-plus circle-3"></i></a>
                                        <?php }?>
                                        <?php if($twitter_profile != ''){?>
                                        <a class="twitter" href="https://<?php echo $twitter_profile; ?>"><i class="fa fa-twitter circle-3"></i></a>
                                        <?php }?>
                                        <?php if($li_profile != ''){?>
                                        <a class="linkedin" href="https://<?php echo $li_profile; ?>"><i class="fa fa-linkedin circle-3"></i></a>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                    </div>
                </div>
                <!-- Team #2 end -->
            </div>
                <!-- Comments section -->
                    <div class="blog-comments">
                        <?php $comment_settings = get_settings('content_settings', 'enable_blog_comment', 'No'); ?>
                        <?php if($comment_settings == 'Disqus Comment'){ ?>
                            <?php $disqus_shortname = get_settings('content_settings', 'disqus_blog_shortname', 'webhelios'); ?>
                            <div id="disqus_thread"></div>
                            <script type="text/javascript">
                                /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                                var disqus_shortname = '<?php echo $disqus_shortname; ?>'; // required: replace example with your forum shortname

                                /* * * DON'T EDIT BELOW THIS LINE * * */
                                (function() {
                                    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                })();
                            </script>
                            <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                            <div class="clearfix"></div>
                        <?php } ?>

                        <?php if($comment_settings == 'Facebook Comment'){ ?>
                            <?php $fb_app_id = get_settings('content_settings', 'fb_blog_comment_app_id', '1510845559191569'); ?>
                            <!--facebook comment review start-->
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
                                }(document, 'script', 'facebook-jssdk'));</script>

                            <div class="clear-top-margin"></div>



                            <div class="fb-comments" data-href=" <?php echo current_url();?>" data-numposts="10" data-colorscheme="light"></div>

                            <!--facebook comment review end-->
                        <?php } ?>
                    </div>

                <?php } ?>

            </div>


            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="sidebar">
                    <?php render_widgets('right_bar_blog_posts');?>
                </div>
            </div>

        </div>
    </div>

</div>
