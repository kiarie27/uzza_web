<?php $CI = get_instance();?>
<div class="clearfix"></div>
<div class="text-center grid-box">
    <?php
    if($posts->num_rows()<=0)
    {
        echo '<div class="alert alert-info">'.lang_key('no_posts').'</div>';
    }
    else
    {
    $i = 0;
    foreach($posts->result() as $post){
        $i++;
        $detail_link = post_detail_url($post);
    ?>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
        <div class="item grid-box-item">
            <!-- Image style one starts -->

            <div class="image-style-one">
                <!-- Image -->
                <a href="<?php echo $detail_link;?>">
                    <img class="img-responsive" alt="<?php echo get_post_data_by_lang($post,'title');?>" src="<?php echo get_featured_photo_by_id($post->featured_img);?>">                        <!-- image hover style for image #1 -->
                </a>

            </div>

            <div class="grid-box-content">
                <?php if($post->featured == 1){ ?>
                    <span class="hot-tag" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo lang_key('featured');?>"><i class="fa fa-bookmark"></i></span>
                <?php } ?>
                    <span class="price-tag" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo lang_key('featured');?>">
                        <?php echo show_price($post->price,$post->ask_for_price);?>
                    </span>
                    <span class="condition-tag" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo lang_key('featured');?>">
                        <?php echo lang_key($post->condition);?>
                    </span>

                <?php
                $class = "fa cat-img-small ";
                $bor_class = "";

                $class .= $CI->post_model->get_category_icon($post->category);
                $cat_featured_img = $CI->post_model->get_category_featured_img($post->category);
                
                if($i%5 == 1)
                {
                    $class .= " bg-red";
                    $bor_class = "bg-red";
                }
                else if($i%5 == 2)
                {
                    $class .= " bg-green";
                    $bor_class = "bg-green";
                }
                else if($i%5 == 3)
                {
                    $class .= " bg-orange";
                    $bor_class = "bg-orange";
                }
                else if($i%5 == 4)
                {
                    $class .= " bg-purple";
                    $bor_class = "bg-purple";
                }
                else
                {
                    $class .= " bg-lblue";
                    $bor_class = "bg-lblue";
                }
                ?>
                <a class="b-tooltip" title="<?php echo get_category_title_by_id($post->category); ?>" href="<?php echo site_url('show/categoryposts/'.$post->category.'/'.dbc_url_title(lang_key(get_category_title_by_id($post->category))));?>">
                    <!--i class="category-fa-icon <?php echo $class;?>"></i-->
                    <img src="<?php echo $cat_featured_img;?>" class="<?php echo $class;?>" />
                </a>
                <div class="cat-title"><?php echo get_category_title_by_id($post->category); ?></div>
                <h4 class="item-title"><a href="<?php echo $detail_link;?>"><?php echo format_long_text(get_post_data_by_lang($post,'title'));?></a></h4>
                <div class="bor <?php echo $bor_class;?>"></div>
                <div class="row">
                    <?php echo get_brand_model_name_by_id($post->brand).' '.get_brand_model_name_by_id($post->model);?>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 info-dta"><i class="fa fa-tachometer"></i> : <?php echo $post->mileage.' '.$this->session->userdata('mileage_unit');?></div>
                </div>
                <?php if(get_settings('content_settings','enable_review','Yes')=='Yes'){?>
                <div class="row grid-rating-holder">
                    <div class="col-xs-12 col-sm-12 col-md-12 info-dta info-price">
                        <?php $average_rating = $post->rating; ?>
                        <?php $half_star_position = check_half_star_position($average_rating); ?>
                        <a href="<?php echo $detail_link;?>#review">
                        <?php echo get_review_with_half_stars($average_rating,$half_star_position);?>
                        </a>
                    </div>
                </div>
                <?php }?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>                

    <?php 
        }
    }
    ?>
</div>
<div class="clearfix"></div>
<?php echo (isset($pages))?'<ul class="pagination">'.$pages.'</ul>':'';?>