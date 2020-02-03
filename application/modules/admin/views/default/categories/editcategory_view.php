<?php echo $this->session->flashdata('msg');?>
<h4><?php echo lang_key('edit_category');?></h4>
<hr/>
      		
      		<form class="form-horizontal" id="save-category-form" action="<?php echo site_url('admin/category/updatecategory');?>" method="post">
      			<input type="hidden" name="id" value="<?php echo $post->id;?>"/>
				<label><?php echo lang_key('title');?>:</label>
				<input type="text" class="form-control" name="title" value="<?php echo(set_value('title')!='')?set_value('title'):$post->title;?>">
				<?php echo form_error('title');?>

				<label><?php echo lang_key('featured_img');?>:</label>
			    <div class="">
			        <input type="hidden" name="featured_img" id="site_logo" value="<?php echo get_car_type_icon('name',$post->featured_img);?>">
			        <img class="thumbnail" id="site_logo_preview" src="<?php echo get_car_type_icon('link',$post->featured_img);?>" width="64px">
			        <iframe src="<?php echo site_url('admin/category/featuredimguploader');?>" style="border:0;margin:0;padding:0;height:50px;"></iframe>
			        <div class="clearfix"></div>
			        <span id="upload-error"><?php echo form_error('featured_img'); ?></span>
			    </div>

				<div class="clearfix"></div>
				<input type="submit" value="<?php echo lang_key('save');?>" class="btn btn-success" style="margin-top:10px;" >
				

			</form>

	  </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	jQuery('#save-category-form').submit(function(event){
		event.preventDefault();
		var loadUrl = jQuery(this).attr('action');
		jQuery("#category-modal  .modal-body").html("Updating...");
		jQuery.post(
			loadUrl,
			jQuery(this).serialize(),
			function(responseText){
				jQuery("#category-modal  .modal-body").html(responseText);
			},
			"html"
		);

	});
</script>	