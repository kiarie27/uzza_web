<script src="<?php echo theme_url();?>/assets/js/waypoints.min.js"></script>
<?php
$CI = get_instance();
$CI->load->model('user/post_model');
$parent_categories = $CI->post_model->get_all_parent_categories();
?>
<div class="counter-four">
						<div class="counter-content">
								<?php $i = 0;
								foreach ($parent_categories->result() as $parent) {
								$i++;
								?>
									<?php
									$class = '';
					                if($i%5 == 1)
					                    $class .= " color-red";
					                else if($i%5 == 2)
					                    $class .= " color-green";
					                else if($i%5 == 3)
					                    $class .= " color-orange";
					                else if($i%5 == 4)
					                    $class .= " color-purple";
					                else
					                    $class .= " color-lblue";
									?>
								<div class="col-md-3 col-sm-4 col-xs-6">
									<!-- counter item -->
									<div class="counter-item">
										<a href="<?php echo site_url('show/categoryposts/'.$parent->id.'/'.dbc_url_title(lang_key($parent->title)));?>">
											<img class="<?php echo $class;?> counter-car-type-icon" src="<?php echo get_car_type_icon("link",$parent->featured_img);?>" />
										</a>
										<!-- Heading -->
										<h4><span class="<?php echo $class;?> number-count" data-from="0" data-to="<?php echo $CI->post_model->count_post_by_category_id($parent->id);?>" data-speed="800" data-refresh-interval="50">500</span></h4>
										<!-- Paragraph -->
										<h6><?php echo lang_key($parent->title); ?></h6>
										<div class="clearfix"></div>
									</div>
								</div>
								<?php } ?>

						<div class="clearfix"></div>
					</div>

</div>
<script type="text/javascript">
	<!-- Counting code -->
	$(document).ready(function(){
		// Way Points With Count To()
		$('.number-count').waypoint(function(down){
			if(!$(this).hasClass('stop-counter'))
			{
				$(this).countTo();
				$(this).addClass('stop-counter');
			}
		}, {
			offset: '90%'
		});
	});
</script>