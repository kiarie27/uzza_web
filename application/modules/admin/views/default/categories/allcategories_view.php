<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">

<div class="row">
  <div class="col-md-12">
    <div class="box">
        <a href="<?php echo site_url('admin/category/newcategory'); ?>" class="btn btn-success" id="create-category">
            <?php echo lang_key('new_category'); ?>
        </a>
        <div style="margin-bottom:20px;"></div>

      <div class="box-title">
        <h3><i class="fa fa-bars"></i> <?php echo lang_key('all_categories');?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">                    
        <?php $this->load->helper('text');?>
        <?php echo $this->session->flashdata('msg');?>
        <?php if($posts->num_rows()<=0){?>
        <div class="alert alert-info"><?php echo lang_key('no')." ".lang_key('category');?></div>
        <?php }else{?>
        <div id="no-more-tables">
        <table id="all-posts" class="table table-hover">
           <thead>
               <tr>
                  <th class="numeric">#</th>
                  <th class="numeric"><?php echo lang_key('title');?></th>
                  <th class="numeric"><?php echo lang_key('image');?></th>
                  <th class="numeric"><?php echo lang_key('actions');?></th>
               </tr>
           </thead>
           <tbody>
        	<?php $i=1;foreach($posts->result() as $row):?>
               <tr>
                  <td data-title="#" class="numeric"><?php echo $i;?></td>
                  <td data-title="<?php echo lang_key('title');?>" class="numeric"><a href="<?php echo site_url('admin/category/edit/'.$row->id);?>"><?php echo lang_key($row->title);?></a></td>
                  <td data-title="<?php echo lang_key('image');?>" class="numeric">
                    <?php if($row->parent==0){?>
                    <img class="thumbnail" style="width:50px;margin-bottom:0px;" src="<?php echo get_car_type_icon('link',$row->featured_img);?>" />
                    <?php }else{echo '&nbsp;';}?>
                  </td>
                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">
                    <div class="btn-group">
                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>
                      <ul class="dropdown-menu dropdown-info">
                          <li><a href="javascript:void(0);" link="<?php echo site_url('admin/category/edit/'.$row->id);?>" onClick="edit(this);"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo lang_key('edit');?></a></li>
                          <li><a href="<?php echo site_url('admin/category/delete/'.$row->id);?>"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo lang_key('delete');?></a></li>
                      </ul>
                    </div>
                  </td>
               </tr>
            <?php $i++;endforeach;?>   
           </tbody>
        </table>
        </div>

        <?php }?>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="category-modal" style="display: none;" aria-hidden="true">
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


<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#all-posts').dataTable();

        jQuery("#create-category").click(function(event){
          event.preventDefault();
          var loadUrl = jQuery(this).attr("href");
          jQuery('#category-modal').modal('show');
          jQuery("#category-modal  .modal-body").html("Loading...");
          jQuery.get(
                  loadUrl,
                  {},
                  function(responseText){
                      jQuery("#category-modal  .modal-body").html(responseText);
                  },
                  "html"
              );
        });

        jQuery(".edit-category").click(function(event){
            event.preventDefault();
            
        });

        jQuery('#category-modal').on('hidden.bs.modal', function () {
            location.reload();
        });


    });

    function edit(e)
    {
            var loadUrl = jQuery(e).attr("link");
            jQuery('#category-modal').modal('show');
            jQuery("#category-modal  .modal-body").html("Loading...");
            jQuery.get(
                    loadUrl,
                    {},
                    function(responseText){
                        jQuery("#category-modal  .modal-body").html(responseText);
                    },
                    "html"
                );

    }
</script>