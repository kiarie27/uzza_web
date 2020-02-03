    <!-- ==================   SCRIPT PART   ================= -->
    <script type="text/javascript" src="<?php echo theme_url();?>/assets/js/bootstrap.min.js" async></script>
    <script type="text/javascript" src="<?php echo theme_url();?>/assets/js/plugins/animsition.min.js" async></script>
    <script type="text/javascript" src="<?php echo theme_url();?>/assets/js/plugins/count-to.min.js" async></script>
    <script type="text/javascript" src="<?php echo theme_url();?>/assets/js/plugins/flex-slider.min.js" async></script>
    <script type="text/javascript" src="<?php echo theme_url();?>/assets/js/app.js" async></script>    
    <script>
         //google analytics code here
    </script>


    <div id="signin-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header login-modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    <h4 class="modal-title" id="myModalLabel"><span class="fa fa-sign-in"></span> <?php echo lang_key('login_to_your_account'); ?> </h4>

                </div>

                <div class="modal-body">

                    <!-- Login starts -->
                    <div class="well login-reg-form">

                        <!-- Form -->
                        <form action="<?php echo site_url('account/login');?>" class="form-horizontal" role="form" method="post">
                            <!-- Form Group -->
                            <div class="form-group">
                                <!-- Label -->
                                <label for="user" class="col-sm-3 control-label"><?php echo lang_key('email'); ?></label>
                                <div class="col-sm-9">
                                    <!-- Input -->
                                    <input type="text" class="form-control" name="useremail" placeholder="<?php echo lang_key('email'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label"><?php echo lang_key('password'); ?></label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control"  name="password" placeholder="<?php echo lang_key('password'); ?>">
                                </div>
                            </div>
                            <?php if(constant("ENVIRONMENT")=='demo'){?>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <div class="checkbox">
                                            <label>
                                                demo user : user@webhelios.com pass: 12345
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> <?php echo lang_key('remember_me'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <!-- Button -->
                                    <button type="submit" class="btn btn-success"><?php echo lang_key('login'); ?></button>&nbsp;
                                    <button type="reset" class="btn btn-white"><?php echo lang_key('reset'); ?></button>
                                </div>
                            </div>
                            <div class="col-sm-offset-3 col-sm-9">
                                <a href="<?php echo site_url('account/recoverpassword');?>" class="black"><?php echo lang_key('forgot_password'); ?> ?</a> 
                                <?php if(get_settings('content_settings','enable_signup','Yes')=='Yes'){?>
                                | <a href="<?php echo site_url('account/signup');?>" class="black"><?php echo lang_key('sign_up'); ?></a>
                                <?php }?>
                            </div>
                        </form>
                        <br /><br />
                        <?php
                        $fb_enabled = get_settings('content_settings','enable_fb_login','No');
                        $gplus_enabled = get_settings('content_settings','enable_gplus_login','No');
                        if($fb_enabled=='Yes' || $gplus_enabled=='Yes'){
                        ?>
                        <!-- Social Media Login -->
                        <div class="s-media text-center">
                            <!-- Button -->
                            <?php if($gplus_enabled=='Yes'){?>
                            <a href="<?php echo site_url('account/newaccount/google_plus');?>" class="btn btn-danger"><i class="fa fa-google-plus"></i> &nbsp; <?php echo lang_key('login_with_google')?></a>
                            <?php }?>
                            <?php if($fb_enabled=='Yes'){?>
                            <a href="javascript:void(0);" onclick="login();" class="btn btn-primary"><i class="fa fa-facebook"></i> &nbsp; <?php echo lang_key('login_with_facebook')?></a>
                            <?php }?>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- Login ends -->

                </div>

                <div class="modal-footer">

                </div>

            </div>

            <!-- /.modal-content -->

        </div>

        <!-- /.modal-dialog -->

    </div>


    <div id="ie-msg-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    <h4 class="modal-title" id="myModalLabel"><?php echo lang_key('upgrade_browser'); ?> </h4>

                </div>

                <div class="modal-body">

                    <div class="alert alert-danger"><?php echo lang_key('please_upgrade_your_browser');?></div>
                </div>

                <div class="modal-footer">

                </div>

            </div>

            <!-- /.modal-content -->

        </div>

        <!-- /.modal-dialog -->

    </div>

    <!-- added on version 1.8 -->
    <div id="adblock-msg-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel2"><?php echo lang_key('adblock_detected');?></h4>
                </div>

                <div class="modal-body">
                    <img alt="<?php echo lang_key('adblock_detected');?>" src="<?php echo theme_url();?>/assets/img/adblock.png" class="img-fluid" />
                    <br/>
                    <br/>
                    <div class="alert alert-danger"><?php echo lang_key('adblock_msg');?></div>
                </div>

                <div class="modal-footer">
                </div>

            </div>
        </div>
    </div>
    <!-- end -->

<!-- added on version 1.8 -->
<?php
if(get_settings('content_settings','enable_cookie_policy_popup','No')=='Yes'){
    require_once 'eu_cookie_popup.php';     
}
?>   
<?php if(get_settings('content_settings','enable_adblocker_alert','No')=='Yes'){?>
<script type="text/javascript">
    var adblock = true;
</script>
<script type="text/javascript" src="<?php echo theme_url();?>/assets/js/adframe.js"></script>
<script type="text/javascript">
    if(adblock) {
        $('#adblock-msg-modal').modal('show'); 
        $('#adblock-msg-modal').on('hide.bs.modal', function(e){
             e.preventDefault();
        });       
    }
</script>
<?php }?>
<!-- end -->

<?php
$ga_tracking_code = get_settings('site_settings','ga_tracking_code','');

if($ga_tracking_code != ''){
    echo $ga_tracking_code;
}

?>
<script type="text/javascript">
jQuery(document).ready(function(){

    if(old_ie==1)
    {
        jQuery('#ie-msg-modal').modal('show');
    }

    jQuery('.signin').click(function(e){
        e.preventDefault();
        jQuery('#signin-modal').modal('show');
    });

});
</script>
<script type="text/javascript">


    $(document).ready(function() {
        
        jQuery('.list-switcher').each(function(){
            var view_type = '<?php echo ($this->session->userdata("view_type")!="")?$this->session->userdata("view_type"):"grid";?>';
            var alias = '<?php echo (isset($alias))?$alias:"";?>';
            if(view_type=='grid')
            jQuery(this).children(":first").trigger('click');           
            else if(view_type!='grid' && alias=='ad_search')
            jQuery(this).children(":nth-child(2)").trigger('click');           
            else
            jQuery(this).children(":first").trigger('click');           
        });

        jQuery('.featured-list-switcher').each(function(){
            jQuery(this).children(":first").trigger('click');
        });
      
        fix_grid_height();


    });

    function fix_grid_height()
    {
        var maxHeight = -1;
        $('.item-title').each(function() {
            maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
        });

        $('.item-title').each(function() {
            $(this).height(maxHeight);
        });

        var maxHeight = -1;
        $('.cat-title').each(function() {
            maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
        });

        $('.cat-title').each(function() {
            $(this).height(maxHeight);
        });

        var maxHeight = -1;
        $('.info-phone').each(function() {
            maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
        });

        $('.info-phone').each(function() {
            $(this).height(maxHeight);
        });

        var maxHeight = -1;
        $('.price-heading').each(function() {
            maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
        });

        $('.price-heading').each(function() {
            $(this).height(maxHeight);
        });
        jQuery('.find-my-location').tooltip();
        jQuery('.hot-tag').tooltip();
        jQuery('.hot-tag-list').tooltip();
    }

</script>