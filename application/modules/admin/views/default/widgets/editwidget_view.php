<?php echo $this->session->flashdata('msg');?>
<?php $this->load->helper('file');?>
<?php $data = read_file('./application/modules/widgets/'.$widget->alias.'.php')?>
<h4>Edit <?php echo $widget->name;?></h4> <button style="position:relative;top:-38px;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<hr/>
<form action="<?php echo site_url('admin/widgets/savewidget');?>" method="post" id="save-widget-form">
<input type="hidden" name="alias" value="<?php echo $widget->alias;?>" />	
<textarea class="form-control" style="height:260px;" name="data" <?php echo ($widget->editable==1)?'':'readonly="readonly"';?>><?php echo ($data!=FALSE)?$data:'';?></textarea>
<input type="submit" value="Update" class="btn btn-success" style="margin-top:10px;" >
</form>
<script type="text/javascript">
	jQuery('#save-widget-form').submit(function(event){
		event.preventDefault();
		var loadUrl = jQuery(this).attr('action');
		jQuery("#editWidgetModal  .modal-body").html("Updating...");
		jQuery.post(
			loadUrl,
			jQuery(this).serialize(),
			function(responseText){
				jQuery("#editWidgetModal  .modal-body").html(responseText);
			},
			"html"
		);

	});
</script>	