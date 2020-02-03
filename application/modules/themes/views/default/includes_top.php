<?php 
$compress_css = get_settings('site_settings','css_compression','No');
if($compress_css=='Yes')
{
?>
<style type="text/css">
.footer-share-links i{
    padding-top: 11px;
}
.member-social-links i{
    padding-top: 11px;    
}
</style>
<link href="<?php echo theme_url();?>/assets/css/all-css.php" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/plugins/font-awsome/font-awsome.min.css">
<?php
}
else
{
?> 
    <link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/Oswald.css">
    <link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/Roboto.css">
    <link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/plugins/font-awsome/font-awsome.min.css">
    <link href="<?php echo theme_url();?>/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo theme_url();?>/assets/css/responsive.css" rel="stylesheet">
    <link href="<?php echo theme_url();?>/assets/css/custom.css" rel="stylesheet">
<?php
}
?> 
    <!--[if lt IE 9]>
    <script src="<?php echo theme_url();?>/assets/js/vendor/modernizr-2.6.2.min.js"></script>
    <![endif]-->
    <script src="<?php echo theme_url();?>/assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo theme_url();?>/assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript">var base_url = '<?php echo base_url();?>';</script> <!-- added on version 1.5 -->
    <script type="text/javascript">var old_ie = 0;</script>
