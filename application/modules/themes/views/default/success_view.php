<div class="page-heading-two">
    <div class="container">
        <div class="col-md-7">            
            <h5><?php echo lang_key('confirmation'); ?></h5>
        </div>
        <div class="col-md-5">
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('confirmation'); ?>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container">
	<div class="row">
	    <div class="col-md-12 min-height-default">
	        <div class="alert alert-info">
            <?php 
            $this->load->config('common');
            if($this->config->item('skip_user_email_confirmation')!='Yes'){
                echo lang_key('reg_success_message'); 
            }else{
                echo lang_key('noconfirm_reg_success_message');
            }
            ?>
	        </div>
	    </div>    
	</div> <!-- /row -->
</div>