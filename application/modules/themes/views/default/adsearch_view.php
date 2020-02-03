 <div class="page-heading-two">
      <div class="container">
          <div class="col-md-7">
              <h5><?php echo lang_key('advanced_search'); ?> <span><?php echo lang_key('narrow_down_your_search'); ?></span></h5>
          </div>
          <div class="col-md-5">
          <div class="breads">
              <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('advanced_search'); ?>
          </div>
          </div>
          <div class="clearfix"></div>
      </div>
  </div>


    <!-- Page heading two ends -->
  
    <div class="container">
      <!-- blog two -->
      <div class="blog-two">
        <?php 
        if($this->session->userdata('search_view_type')=='plain' || $this->session->userdata('search_view_type')=='')
          require'plain_search_view.php';
        else
          require'map_search_view.php';
        ?>
      </div>    
    </div>


