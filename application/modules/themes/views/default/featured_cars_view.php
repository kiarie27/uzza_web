<div class="page-heading-two">
    <div class="container">
        <div class="col-md-7">
            <h5><?php echo lang_key('featured_cars');?></h5>
        </div>
        <div class="col-md-5">
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('featured_cars'); ?>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Container -->
<div class="container">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php render_widget('featured_posts_main');?>
            <div class="clearfix"></div>
        </div>
        
    </div>
</div>
