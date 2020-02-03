<div class="page-heading-two">
    <div class="container">
        <div class="col-md-7">            
            <h5><?php echo lang_key('recover');?></h5>
        </div>
        <div class="col-md-5">
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('recover'); ?>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 min-height-default">
            <div class="panel panel-default">
                <div class="panel-body">

                    <form action="<?php echo site_url('account/recoverpassword/');?>" method="post">
                        <?php echo $this->session->flashdata('msg');?>
                        <div class="top-margin">
                            <label><?php echo lang_key('email'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="user_email" value="<?php echo set_value('user_email');?>" class="form-control">
                        </div>
                        <?php echo form_error('user_email');?>
                        <hr>

                        <div class="row">
                            <div class="col-lg-8">
                                <label class="checkbox">
                                    <a target="_blank" href="<?php echo site_url('account/signup');?>"><?php echo lang_key('sign_up'); ?></a>
                                </label>
                            </div>
                            <div class="col-lg-4 text-right">
                                <button class="btn btn-primary" type="submit"><?php echo lang_key('recover'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- /row -->
</div>

