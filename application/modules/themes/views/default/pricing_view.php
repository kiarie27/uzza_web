<div class="page-heading-two">
    <div class="container">
        <div class="col-md-7">            
            <h5><?php echo lang_key('all_packages');?></h5>
        </div>
        <div class="col-md-5">
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('choose_a_package'); ?>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container">
    <div class="block-heading-two">
        <h3><span><i class="fa fa-money"></i> <?php echo lang_key('post_package');?></span></h3>
    </div>

    <?php
    if($post_packages->num_rows()<=0){
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

                <?php foreach($post_packages->result() as $package):?>
                    <?php if(isset($renew) && $renew=='renew' && $package->price<=0)continue;?>
                    <?php $action = (isset($renew) && $renew=='renew')?site_url('user/payment/renewpackage'):site_url('user/payment/takepackage');?>
                <form action="#" method="post">
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
                                <li><?php echo lang_key('limit'); ?> <span class="pull-right"><?php echo $package->expiration_time;?> <?php echo lang_key('days'); ?></span></li>
                                <li><?php echo lang_key('featured'); ?> <span class="pull-right"><?php echo $package->featured_expiration_time;?> <?php echo lang_key('days'); ?></span></li>
                                <li><?php echo lang_key('gallery_limit'); ?> <span class="pull-right"><?php echo $package->max_gallery_photos;?> <?php echo lang_key('photos'); ?></span></li>
                            </ul> <!-- //price-feature -->
                            
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


<div class="container">
    <div class="block-heading-two">
        <h3><span><i class="fa fa-money"></i> <?php echo lang_key('featured_package');?></span></h3>
    </div>

    <?php
    if($featured_packages->num_rows()<=0){
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

                <?php foreach($featured_packages->result() as $package):?>
                    <?php if(isset($renew) && $renew=='renew' && $package->price<=0)continue;?>
                    <?php $action = (isset($renew) && $renew=='renew')?site_url('user/payment/renewpackage'):site_url('user/payment/takepackage');?>
                <form action="#" method="post">
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
                                <li><?php echo lang_key('featured'); ?> <span class="pull-right"><?php echo $package->featured_expiration_time;?> <?php echo lang_key('days'); ?></span></li>
                            </ul> <!-- //price-feature -->
                            
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