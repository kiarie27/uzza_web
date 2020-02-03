<?php 
$curr_page = $this->uri->segment(5);
if($curr_page=='')
  $curr_page = 0;
?>
<div class="row">

  <div class="col-md-12">

    <a href="<?php echo site_url('admin/brandmodels/newbrandmodel/brand');?>" class="btn btn-success add-brandmodel"><?php echo lang_key('add_brand');?></a>
    <a href="<?php echo site_url('admin/brandmodels/newbrandmodel/model');?>" class="btn btn-info add-brandmodel"><?php echo lang_key('add_model');?></a>
    <div style="clear:both;margin-top:20px;"></div>

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key('brandmodels');?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>


        </div>

      </div>

      <div class="box-content">

        
        <div class="col-md-6 col-sm-12 col-xs-12 pull-right">
          
          <form action="<?php echo site_url('admin/brandmodels/all/0');?>" method="post" id="table-search-from" class="form-inline pull-right">
            <div class="">
              <label class="sr-only" for="exampleInputAmount"><?php echo lang_key('search');?>:</label>
              <div class="input-group">
                <input type="text" name="key" class="form-control" id="key" value="<?php echo $this->input->post('key');?>" placeholder="<?php echo lang_key('name');?>">
                <div class="input-group-addon search-plain" style="cursor:pointer;border-radius:0 5px 5px 0"><i class="search fa fa-search"></i></div>
              </div>
            </div>
          </form>

        </div>

        <div class="clearfix"></div>
        <?php echo $this->session->flashdata('msg');?>

        <?php if(count($posts)<=0){?>

        <div class="alert alert-info"><?php echo lang_key('no_brandmodels');?></div>

        <?php }else{?>

        <div id="no-more-tables">

        <table class="table table-hover">

           <thead>

               <tr>

                  <th class="numeric">#</th>

                  <th class="numeric"><?php echo lang_key('name');?></th>

                  <th class="numeric"><?php echo lang_key('type');?></th>

                  <th class="numeric"><?php echo lang_key('parent');?></th>

                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

        	<?php $i=1;foreach($posts as $row):
                $dash = '';
                if($row->type=='model')
                  $dash = '|___';
          ?>

               <tr>

                  <td data-title="#" class="numeric"><?php echo $i;?></td>

                  <td data-title="<?php echo lang_key('name');?>" class="numeric"><?php echo $dash.' '.$row->name;?></td>

                  <td data-title="<?php echo lang_key('type');?>" class="numeric"><?php echo $row->type;?></td>

                  <td data-title="<?php echo lang_key('parent');?>" class="numeric">

                    <?php echo get_brand_model_name_by_id($row->parent);?>

                  </td>

                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                    <div class="btn-group">

                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="ui_button.html#"><i class="fa fa-cog"></i> <?php echo lang_key('actions');?> <span class="caret"></span></a>

                      <ul class="dropdown-menu dropdown-info">

                          <li><a href="<?php echo site_url('admin/brandmodels/editbrandmodel/'.$row->type.'/'.$row->id);?>" class="edit-brandmodel"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo lang_key('edit');?></a></li>
                          <li><a href="<?php echo site_url('admin/brandmodels/deletebrandmodel/'.$curr_page.'/'.$row->id);?>"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo lang_key('delete');?></a></li>

                      </ul>

                    </div>

                  </td>

               </tr>

            <?php $i++;endforeach;?>   

           </tbody>

        </table>

        </div>

        <div class="pagination"><ul class="pagination pagination-colory"><?php echo (isset($pages))?$pages:'';?></ul></div>

        <?php }?>

        </div>

    </div>

  </div>

</div>


<!-- Modal -->
<div class="modal fade" id="brandmodel-model" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="border-bottom:0px;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
            <div class="modal-body"  style="padding-top:0px;">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
    
    jQuery(".add-brandmodel").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#brandmodel-model').modal('show');
        jQuery("#brandmodel-model  .modal-body").html("Loading...");
        jQuery.get(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#brandmodel-model  .modal-body").html(responseText);
                },
                "html"
            );
    });

    jQuery(".edit-brandmodel").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#brandmodel-model').modal('show');
        jQuery("#brandmodel-model  .modal-body").html("Loading...");
        jQuery.get(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#brandmodel-model  .modal-body").html(responseText);
                },
                "html"
            );
    });

    jQuery('#brandmodel-model').on('hidden.bs.modal', function () {
        location.reload();
    });

    jQuery('.search').click(function(e){
      jQuery('#table-search-from').submit();
    });
});
</script>
