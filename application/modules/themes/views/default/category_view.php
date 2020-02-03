<?php $CI = get_instance();?>
<div class="page-heading-two">
    <div class="container">
        <div class="col-md-7">
            <h5><?php echo lang_key('categories'); ?></h5>
        </div>
        <div class="col-md-5">
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('categories'); ?>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Container -->
<div class="container">

    <div class="row">

        <div class="col-md-9 col-sm-12 col-xs-12">
            
            <div class="icon-box-1 text-center">
                <?php 
                $i = 0;

                foreach ($categories->result()  as $car_type) {
                    $i++;
                ?>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <!-- Icon Box One Item -->
                    <div class="icon-box-1-item category-item">
                        <!-- Icon Box One Icon -->
                        <?php
                            $class = '';
                            if($i%5 == 1) 
                                $class = "red";
                            else if($i%5 == 2)
                                $class = "green";
                            else if($i%5 == 3)
                                $class = "purple";
                            else if($i%5 == 3)
                                $class = "orange";
                            else
                                $class = "blue";
                        ?>
                        <a href="<?php echo site_url('show/categoryposts/'.$car_type->id.'/'.dbc_url_title(lang_key($car_type->title)));?>">
                            <img alt="<?php echo lang_key($car_type->title);?>" class="car-icon" src="<?php echo get_car_type_icon("link",$car_type->featured_img);?>" />
                        </a>
                        <div class="category-bor bg-<?php echo $class;?>"></div>
                        <!-- Icon Box One Headeing -->
                        <div class="cat-main-widget-title">
                            <a href="<?php echo site_url('show/categoryposts/'.$car_type->id.'/'.dbc_url_title(lang_key($car_type->title)));?>">
                                <?php echo lang_key($car_type->title);?>&nbsp;<span dir="rtl">(<?php echo $CI->post_model->count_post_by_category_id($car_type->id);?>)</span>
                            </a>
                        </div>
                        <!-- Icon Box One Paragraph -->
                        
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="clearfix"></div>            
        </div>


        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="sidebar">
                <?php render_widgets('right_bar_categories');?>
            </div>
        </div>

    </div>
</div>
