<div class="page-heading-two">
    <div class="container">
        <div class="col-md-7">
            <h5><?php echo lang_key('choose_a_package');?></h5>
        </div>
        <div class="col-md-5">
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('choose_a_package'); ?>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Container -->
<div class="container">
    <?php
    if($packages->num_rows()<=0){
        ?>
        <div class="alert alert-danger"><?php echo lang_key('no_package_found'); ?></div>
    <?php
    }
    else
    {
    ?>
    <?php echo $this->session->flashdata('msg');?>

    <!-- Pricing table #1 starts -->
    <div class="pricing-one">
        <div class="container">
            <div class="row">

                <?php foreach($packages->result() as $package):?>
                    <?php if(isset($renew) && $renew=='renew' && $package->price<=0)continue;?>
                    <?php $action = (isset($renew) && $renew=='renew')?site_url('user/payment/renewpackage'):site_url('user/payment/takepackage');?>
                <form action="<?php echo $action;?>" method="post">
                    <input type="hidden" name="package_id" value="<?php echo $package->id;?>">
                    <?php 
                     if(isset($renew_post_id)) {
                    ?>
                    <input type="hidden" name="renew_post_id" value="<?php echo $renew_post_id;?>">
                    <?php }?>
                    <div class="col-md-3 col-sm-4">
                        <div class="pricing-table">
                            <div class="price-heading">
                                <div class="price-group text-center">
                                    <span class="price"><?php echo lang_key($package->title);?></span>
                                </div>
                            </div> <!-- //price-heading -->
                            <ul class="price-feature">
                                <li><?php echo lang_key('price'); ?> <span class="pull-right"><?php echo show_package_price($package->price);?></span></li>
                                <?php if($package->type=='post_package'){?>
                                <li><?php echo lang_key('limit'); ?> <span class="pull-right"><?php echo $package->expiration_time;?> <?php echo lang_key('days'); ?></span></li>
                                <?php }?>
                                <li><?php echo lang_key('featured'); ?> <span class="pull-right"><?php echo $package->featured_expiration_time;?> <?php echo lang_key('days'); ?></span></li>
                                <?php if($package->type=='post_package'){?>
                                <li><?php echo lang_key('gallery_limit'); ?> <span class="pull-right"><?php echo $package->max_gallery_photos;?> <?php echo lang_key('photos'); ?></span></li>
                                <?php }?>
                            </ul> <!-- //price-feature -->
                            <div class="price-footer text-center">
                                <button class="btn btn-success" type="submit">
                                    <?php echo lang_key('take_package'); ?>
                                </button>
                            </div>
                        </div>
                        <div class="hr-divider"></div>
                    </div>
                </form>

                <?php endforeach;?>
                <div class="clearfix"></div>

            </div>
        </div>
    </div>
    <!-- Pricing #1 ends -->
    <?php
    }
    ?>
</div>