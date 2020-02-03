<?php echo $this->session->flashdata('msg');?>
<h4><?php echo lang_key('edit');?> <?php echo lang_key($item);?></h4>
<hr/>

<form action="<?php echo site_url('admin/caroptions/update/'.$item);?>" method="post" id="save-option-form">
	<input type="hidden" name="id" value="<?php echo $id;?>">

	<?php 
	if($item=='cartypes')
	{
	?>
	<label><?php echo lang_key('name');?>:</label>
	<input type="text" class="form-control" name="<?php echo $item;?>" value="<?php echo $name->name;?>">
	<?php echo form_error($item);?>

	<label><?php echo lang_key('icon');?>:</label>
    <div class="">
        <input type="hidden" name="icon" id="site_logo" value="<?php echo get_car_type_icon('name',$name->icon);?>">
        <img class="thumbnail" id="site_logo_preview" src="<?php echo get_car_type_icon('link',$name->icon);?>" width="64px">
        <iframe src="<?php echo site_url('admin/caroptions/icon_uploader');?>" style="border:0;margin:0;padding:0;height:50px;"></iframe>
        <div class="clearfix"></div>
        <span id="upload-error"><?php echo form_error('site_logo'); ?></span>
    </div>

	<?php
	}
	else
	{
	?>

	<label><?php echo lang_key('name');?>:</label>
	<input type="text" class="form-control" name="<?php echo $item;?>" value="<?php echo $name;?>" >
	<?php echo form_error($item);?>
	<?php
	}
	?>
	<div class="clearfix"></div>
	<input type="submit" value="Update" class="btn btn-success" style="margin-top:10px;" >
</form>


<script type="text/javascript">
	jQuery('#save-option-form').submit(function(event){
		event.preventDefault();
		var loadUrl = jQuery(this).attr('action');
		jQuery("#option-modal  .modal-body").html("Updating...");
		jQuery.post(
			loadUrl,
			jQuery(this).serialize(),
			function(responseText){
				jQuery("#option-modal  .modal-body").html(responseText);
			},
			"html"
		);

	});
</script>	