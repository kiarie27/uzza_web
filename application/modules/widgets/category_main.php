<?php
$CI = get_instance();
$CI->load->model('user/post_model');
$car_types = $CI->post_model->get_all_parent_categories();
?>

<div class="block-heading-two">
    <h3><span><i class="fa fa-folder"></i> <?php echo lang_key('categories') ?></span></h3>
</div>

<div class="icon-box-1 text-center">
    <?php 
    $i = 0;
    foreach ($car_types->result() as $id=>$car_type) {
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
            <a href="<?php echo site_url('show/categoryposts/'.$id.'/'.dbc_url_title(lang_key($car_type->title)));?>">
                <img alt="<?php echo lang_key($car_type->title);?>" class="car-icon" src="<?php echo get_car_type_icon("link",$car_type->featured_img);?>" />
            </a>
            <div class="category-bor bg-<?php echo $class;?>"></div>
            <!-- Icon Box One Headeing -->
            <div class="cat-main-widget-title">
                <a href="<?php echo site_url('show/categoryposts/'.$id.'/'.dbc_url_title(lang_key($car_type->title)));?>">
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
<!-- category box end -->

 <div id="category-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    <h4 class="modal-title" id="myModalLabel2"><?php echo lang_key('all_sub_categories'); ?> </h4>

                </div>

                <div class="modal-body">

                    
                </div>

                <div class="modal-footer">

                </div>

            </div>

            <!-- /.modal-content -->

        </div>

        <!-- /.modal-dialog -->

    </div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.see_all_sub_cat').click(function(e){
            e.preventDefault();
            jQuery('#category-modal').modal('show');

            var load_url = jQuery(this).attr('href');
              jQuery.post(
                  load_url,
                  {},
                  function(responseText){   
                    jQuery('#category-modal  .modal-body').html(responseText);
                  }
              ); 
          
        });

    });

</script>