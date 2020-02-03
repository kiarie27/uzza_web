<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <?php
    $page = get_current_page();    
    if (!isset($sub_title))
        $sub_title = (isset($page['title'])) ? lang_key($page['title']) : lang_key('list_car');
    if(!isset($seo))
        $seo = (isset($page['seo_settings']) && $page['seo_settings'] != '') ? (array)json_decode($page['seo_settings']) : array();
    if (!isset($meta_desc))
        $meta_desc = (isset($seo['meta_description'])) ? lang_key($seo['meta_description']) : lang_key(get_settings('site_settings', 'meta_description', 'autocon car dealership'));
    if (!isset($crawl_after))
        $crawl_after = (isset($seo['crawl_after'])) ? $seo['crawl_after'] : get_settings('site_settings', 'crawl_after', 3);

    if(isset($post))
    {
        echo (isset($post))?social_sharing_meta_tags_for_post($post):'';
    }
    elseif(isset($blog_meta))
    {
        echo (isset($blog_meta))?social_sharing_meta_tags_for_blog($blog_meta):'';
    }
    ?>

    <title><?php echo translate(get_settings('site_settings', 'site_title', 'Carbiz- Buy Sell Car CMS')); ?><?php echo translate(lang_key($sub_title)); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <?php 
    $alias = (isset($alias))?$alias:'';
    $curr_lang = get_current_lang();
    //echo $alias."_".$curr_lang.".html";die;
    if(@file_exists(FCPATH."web_config/locals-meta/".$alias."_".$curr_lang.".html"))
    {
        require FCPATH."web_config/locals-meta/".$alias."_".$curr_lang.".html";
    }
    else
    {
        if(!isset($post) && !isset($blog_meta))
        {
            $page_title = translate(get_settings('site_settings', 'site_title', 'Carbiz-Buy Sell Car CMS')).'|'.translate(lang_key($sub_title));
            $fb_app_id = get_settings('content_settings','fb_app_id','none');

    ?>
    <meta name="description" content="<?php echo lang_key($meta_desc); ?>">
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@<?php echo lang_key(get_settings('site_settings','twitter_page_name','carbiz'));?>">
    <meta name="twitter:url" content="<?php echo get_the_current_url();?>" />
    <meta name="twitter:title" content="<?php echo lang_key($page_title);?>" />
    <meta name="twitter:description" content="<?php echo lang_key($meta_desc);?>" />
    <meta name="twitter:image" content="<?php echo base_url('assets/images/site-default.jpg');?>" />

    <meta property="og:title" content="<?php echo lang_key($page_title);?>" />
    <meta property="og:site_name" content="<?php echo lang_key(get_settings('site_settings','facebook_page_name','carbiz'));?>" />
    <meta property="og:url" content="<?php echo get_the_current_url();?>" />
    <meta property="og:description" content="<?php echo lang_key($meta_desc);?>" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="<?php echo base_url('assets/images/site-default.jpg');?>" />
    <?php  if($fb_app_id!='' && $fb_app_id!='none'){ ?>
    <meta property="fb:app_id" content="<?php echo get_settings('content_settings','fb_app_id','none');?>" />
    <?php }?>
    <?php  if(isset($page['alias']) && $page['alias']=='home'){ ?>
    <link rel="canonical" href="<?php echo get_the_current_url();?>"/>
    <?php }?>
    <link rel="publisher" href="https://plus.google.com/+<?php echo lang_key(get_settings('site_settings','google_plus_name','carbiz'));?>">
    <?php 
    $this->load->config('common');
    $languages = $this->config->item('active_languages');
    foreach ($languages as $short_name=>$long_name) {
        $lang_url = str_replace(get_current_lang().'/', '',uri_string());
        $lang_url = str_replace(get_current_lang(), '',$lang_url);
    ?>
    <link rel="alternate" hreflang="<?php echo $short_name;?>" href="<?php echo site_url($lang_url,$short_name);?>">
    <?php
    }
    ?>
    
    <?php
        }
    }
    ?>

    <meta name="revisit-after" content="<?php echo $crawl_after; ?> days">
    <!-- ========== FAVICON ========== -->
    <link rel="shortcut icon" href="<?php echo theme_url();?>/assets/img/favicon.ico">

    <?php require'includes_top.php';?>


<?php

    $top_bar_bg_color = get_settings('banner_settings', 'top_bar_bg_color', '#fdfdfd');

    $bg_color = get_settings('banner_settings', 'menu_bg_color', '#ffffff');

    $text_color = get_settings('banner_settings', 'menu_text_color', '#666');

    $active_text_color = get_settings('banner_settings', 'active_menu_text_color', '#32c8de');

    ?>

<style>
    <?php if($alias!='home'){?>
    .top-bar{
        background: <?php echo $top_bar_bg_color;?>; 
    }
    <?php }?>
    
    #header,#header.box-header .box-header-wrap,#header.sticky-header.box-header{
        background: <?php echo $bg_color;?>; 
    }
    .main-nav ul li .dropdown{
        background: <?php echo $bg_color;?>; 
    }
    #header .dropdown-items > li{
        background: <?php echo $bg_color;?>; 
    }
    #header.static-header .main-nav > ul > li > a,#header.box-header .box-header-wrap .main-nav > ul > li > a{
        color: <?php echo $text_color;?>
    }
    #header .dropdown-items > li a{
        color: <?php echo $text_color;?>        
    }

    #header.static-header .main-nav > ul > li > a:hover,#header.box-header .box-header-wrap .main-nav > ul > li > a:hover{
        color: <?php echo $active_text_color;?>
    }
    #header .dropdown-items > li a:hover{
        color: <?php echo $active_text_color;?>        
    }
    #header.static-header .main-nav > ul > .active > a{
        color: <?php echo $active_text_color;?>
    }
    #header .dropdown-items > .active a{
        color: <?php echo $active_text_color;?>        
    }

    .home-search-panel{
        padding: 15px 0 0 0;
        border-top: 2px solid #bbb;
        <?php 
        if(get_settings('banner_settings','show_bg_image','0')==1)
        {
        ?>
        background: <?php echo get_settings('banner_settings','search_panel_bg_color','#222222')?> url(<?php echo base_url('uploads/banner/'.get_settings('banner_settings','search_bg','heading-back.jpg'));?>) center center repeat fixed;
        <?php 
        }else{
        ?>
        background: <?php echo get_settings('banner_settings','search_panel_bg_color','#222222')?>;        
        <?php    
        }
        ?>
    }
</style>

<script type="text/javascript">var base_url = '<?php echo base_url();?>';</script> <!-- added on version 1.5 -->
<script type="text/javascript">var old_ie = 0;</script>
<!--[if lte IE 8]> <script type="text/javascript"> old_ie = 1; </script> < ![endif]-->


</head><!--/head-->

<?php
$CI = get_instance();
$curr_lang = get_current_lang();
if(in_array($curr_lang, $this->config->item('rtl_langs')))
{
?>
<link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/rtl-fix.css">
<body class="page-top" dir="rtl">
<?php 
}else{
?>
<body class="page-top" dir="<?php echo get_settings('site_settings','site_direction','ltr');?>">
<?php 
}
?>
<?php 
$fb_enabled = get_settings('content_settings','enable_fb_login','No');
if($fb_enabled=='Yes'){
    require'fb-login.php';
}
?>


    <div id="page-wrap" class="animsition">

        <?php require'header.php';?>

        <?php if(isset($alias) && $alias=='home'){?>
        <!-- ========== TEXT SLIDER SECTION ========== -->
        <section class="advanced-slider-wrapper">
                
<?php 
    if($alias=='home')
    {
        if(get_settings('banner_settings','show_banner','Yes')=='Yes')
        {
            if(constant("ENVIRONMENT")=='demo')
            $banner_type = (isset($banner_type))?$banner_type:get_settings('banner_settings','banner_type','Layer Slider');             
            else
            $banner_type = get_settings('banner_settings','banner_type','Layer Slider');             

            if($banner_type == 'Parallax Slider'){
                require_once 'slider_view.php';
            }
            else if($banner_type == 'Layer Slider'){
                require_once 'layer_slider.php';
            }
            else{
                require_once 'map_view.php';
            }            
        }
    }
?>



        </section>
        <!-- //End simple slider -- >
        <?php }?>



        <!-- ========== PORTFOLIO SECTION ========== -->
        <section id="portfolio" class="">
            <?php echo (isset($content))?$content:'';?>
        </section>
        <!-- //End portfolio -->

        <?php require'footer.php';?>


    </div>
    <!-- //End page-wrap -->


    <?php require'includes_bottom.php';?>

</body>

<!-- Mirrored from northui.com/carbiz/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Oct 2017 13:39:34 GMT -->
</html>
