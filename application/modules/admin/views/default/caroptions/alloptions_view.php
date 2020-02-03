<?php 
$curr_page = $this->uri->segment(6);
if($curr_page=='')
  $curr_page = 0;
?>
<div class="row">

  <div class="col-md-12">

    <a href="<?php echo site_url('admin/caroptions/create/'.$item);?>" class="btn btn-success create-conditions"><?php echo lang_key('create').' '.lang_key($item);?></a>
    <div style="clear:both;margin-top:20px;"></div>

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key($item);?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>


        </div>

      </div>

      <div class="box-content">

        
        <div class="col-md-6 col-sm-12 col-xs-12 pull-right">
          
          <form action="<?php echo site_url('admin/caroptions/all/'.$item.'/0');?>" method="post" id="table-search-from" class="form-inline pull-right">
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

        <?php if(isset($posts['error'])){?>

        <div class="alert alert-info"><?php echo lang_key('no').' '.lang_key($item);?></div>

        <?php }else{?>

        <div id="no-more-tables">

        <table class="table table-hover">

           <thead>

               <tr>

                  <th class="numeric">#</th>

                  <th class="numeric"><?php echo lang_key('name');?></th>

                  <?php if($item=='cartypes'){?>
                  <th class="numeric"><?php echo lang_key('icon');?></th>
                  <?php }?>

                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

        	<?php $i=(1*$curr_page);foreach($posts as $key=>$val):
          ?>

               <tr>

                  <td data-title="#" class="numeric"><?php echo $i+1;?></td>

                  <td data-title="<?php echo lang_key('name');?>" class="numeric"><?php echo (isset($val->name))?lang_key($val->name):lang_key($val);?></td>
                 
                  <?php if($item=='cartypes'){?>
                  <td data-title="<?php echo lang_key('icon');?>" class="numeric"><img src="<?php echo get_car_type_icon('link',$val->icon);?>" style="width:32px;"/></td>
                  <?php }?>

                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                    <div class="btn-group">

                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('actions');?> <span class="caret"></span></a>

                      <ul class="dropdown-menu dropdown-info">

                          <li><a href="<?php echo site_url('admin/caroptions/edit/'.$item.'/'.$i);?>" class="edit-option"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo lang_key('edit');?></a></li>
                          <li><a href="<?php echo site_url('admin/caroptions/delete/'.$curr_page.'/'.$item.'/'.$i);?>"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo lang_key('delete');?></a></li>

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
<div class="modal fade" id="option-modal" style="display: none;" aria-hidden="true">
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
    
    jQuery(".create-conditions").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#option-modal').modal('show');
        jQuery("#option-modal  .modal-body").html("Loading...");
        jQuery.get(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#option-modal  .modal-body").html(responseText);
                },
                "html"
            );
    });

    jQuery(".edit-option").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#option-modal').modal('show');
        jQuery("#option-modal  .modal-body").html("Loading...");
        jQuery.get(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#option-modal  .modal-body").html(responseText);
                },
                "html"
            );
    });

    jQuery('#option-modal').on('hidden.bs.modal', function () {
        location.reload();
    });

    jQuery('.search').click(function(e){
      jQuery('#table-search-from').submit();
    });
});
</script>
