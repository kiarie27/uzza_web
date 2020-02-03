<?php echo $this->session->flashdata('msg');?>
<h4><?php echo lang_key('create');?> <?php echo lang_key('customfield');?></h4>
<hr/>
<style type="text/css">
	.clearfix{
		margin-top: 10px;
	}
</style>

<form action="<?php echo site_url('admin/customfields/update');?>" method="post" id="save-option-form">
<input type="hidden" name="id" value="<?php echo $id;?>">
<div class="row">
	<div class="col-md-6">
			<label><?php echo lang_key('category_id');?>:</label>
			<select class="form-control" name="category_id">
				<option value=""><?php echo lang_key('all_categories');?></option>
				<?php 
				$v = (set_value('category_id')!='')?set_value('category_id'):$post->category_id;

				foreach ($categories->result() as $row) {
					$sel = ($v==$row->id)?'selected="selected"':'';
				?>
				<option value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo lang_key($row->title);?></option>
				<?php
				}
				?>
			</select>
			<?php echo form_error('category_id');?>
			<div class="clearfix"></div>
	</div>
	<div class="col-md-6">
			<label><?php echo lang_key('fieldtype');?>:</label>
			<select class="form-control" name="fieldtype">
				<option value=""><?php echo lang_key('sel_fieldtype');?></option>
				<?php 
				$options = array('text','textarea','richtext','select','radio','checkbox');
				$v = (set_value('fieldtype')!='')?set_value('fieldtype'):$post->type;

				foreach ($options as $option) {
					$sel = ($v==$option)?'selected="selected"':'';
				?>
				<option value="<?php echo $option;?>" <?php echo $sel;?>><?php echo lang_key($option);?></option>
				<?php
				}
				?>
			</select>
			<?php echo form_error('fieldtype');?>
			<div class="clearfix"></div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
			<label><?php echo lang_key('fieldname');?>:</label>
			<input class="form-control" type="text" name="fieldname" value="<?php echo(set_value('fieldname')!='')?set_value('fieldname'):$post->name;?>">
			<?php echo form_error('fieldname');?>
			<div class="clearfix"></div>

	</div>
</div>
<div class="row">	
	<div class="col-md-12">
		<label><?php echo lang_key('options');?>:</label>
		<input class="form-control" type="text" name="options" value="<?php echo(set_value('options')!='')?set_value('options'):$post->options;?>">
		<div class="alert alert-info">If using Checkbox, Radio or Select field types, you can specify the options available by adding a list of values separated by a comma. Example: Red,Blue,Yellow,Green.</div>
		<?php echo form_error('options');?>
		<div class="clearfix"></div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<label><?php echo lang_key('help_text');?>:</label>
		<input class="form-control" type="text" name="help_text" value="<?php echo(set_value('help_text')!='')?set_value('help_text'):$post->help_text;?>">
		<?php echo form_error('help_text');?>
		<div class="clearfix"></div>		
	</div>
</div>
<div class="row">	
	<div class="col-md-4">
		<?php 
		$v = (set_value('is_required')!='')?set_value('is_required'):$post->is_required;
		$chk = ($v==1)?'checked="checked"':'';
		?>
		<input type="checkbox" class="" name="is_required" id="is_required" value="1" <?php echo $chk;?>> <label for="is_required"><?php echo lang_key('is_required');?></label>
		<?php echo form_error('is_required');?>
		<div class="clearfix"></div>		
	</div>
	<div class="col-md-4">
		<?php 
		$v = (set_value('show_in_detail')!='')?set_value('show_in_detail'):$post->show_in_detail;
		$chk = ($v==1)?'checked="checked"':'';
		?>
		<input type="checkbox" class="" name="show_in_detail" id="show_in_detail" value="1" <?php echo $chk;?>> <label for="show_in_detail"><?php echo lang_key('show_in_detail');?></label>
		<?php echo form_error('show_in_detail');?>
		<div class="clearfix"></div>		
	</div>
	<!--div class="col-md-4">
		<?php 
		$v = (set_value('show_in_search')!='')?set_value('show_in_search'):$post->show_in_search;
		$chk = ($v==1)?'checked="checked"':'';
		?>
		<input type="checkbox" class="" name="show_in_search" id="show_in_search" value="1" <?php echo $chk;?>> <label for="show_in_search"><?php echo lang_key('show_in_search');?></label>
		<?php echo form_error('show_in_search');?>
		<div class="clearfix"></div>		
	</div-->
</div>

<input type="submit" value="<?php echo lang_key('save');?>" class="btn btn-success" style="margin-top:10px;" >
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