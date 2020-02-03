<link rel="stylesheet" href="<?php echo theme_url();?>/assets/ionrange-slider/css/ion.rangeSlider.css">
<script src="<?php echo theme_url();?>/assets/ionrange-slider/js/ion.rangeSlider.min.js" defer></script>
<?php $CI = get_instance(); ?>
<?php 
$filter_type = get_settings('banner_settings','search_panel_filter_type','basic_options'); 
$state_active = get_settings('content_settings', 'show_state_province', 'yes');
$css_class = 'col-md-3 col-sm-3 col-xs-12';
?>
<div class="home-search-panel">
    <div class="re-big-form">
        <div class="container">
            <!-- Nav tab style 2 starts -->
            <div class="nav-tabs-two search-panel-tab">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                </ul>
                <!-- Tab content -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab-1">

                        <form role="form" action="<?php echo site_url('show/advfilter')?>" method="post">
                            <div class="row">
                                
                                <div class="<?php echo $css_class;?>">
                                    <div class="form-group">
                                        <label for="input-14"><?php echo lang_key('category');?></label>
                                        <?php
                                        $CI = get_instance();
                                        $CI->load->model('user/post_model');
                                        $categories = $CI->post_model->get_all_categories();
                                        ?>
                                        <select id="input-14" name="category" class="form-control chosen-select">
                                            <option value="any"><?php echo lang_key('any_category');?></option>
                                              <?php foreach ($categories as $row) {
                                                  $sub = ($row->parent!=0)?'--':'';
                                                  $sel = (set_value('category')==$row->id)?'selected="selected"':'';
                                              ?>
                                                  <option value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo $sub.lang_key($row->title);?></option>
                                              <?php
                                              }?>
                                        </select>
                                    </div>
                                </div>


                                <div class="<?php echo $css_class;?>">
                                    <div class="form-group">
                                        <label for="input-11"><?php echo lang_key('brand');?></label>
                                        <select name="brand" id="select-brand" class="form-control chosen-select">
                                            <option data-name="" value=""><?php echo lang_key('select_brand');?></option>
                                            <?php foreach ($brands->result() as $brand) {
                                              $sel = ($brand->id==set_value('brand'))?'selected="selected"':'';
                                              ?>
                                              <option data-name="<?php echo lang_key($brand->name);?>" value="<?php echo $brand->id;?>" <?php echo $sel;?>><?php echo lang_key($brand->name);?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="<?php echo $css_class;?>">
                                    <div class="form-group">
                                        <label for="input-11"><?php echo lang_key('model');?></label>
                                        <select name="model" id="select-model" class="form-control chosen-select">
                                            <option data-name="" value=""><?php echo lang_key('select_model');?></option>
                                            <?php foreach ($models->result() as $model) {
                                                $sel = ($model->id==set_value('model'))?'selected="selected"':'';
                                            ?>
                                                <option data-name="<?php echo lang_key($model->name);?>" value="<?php echo $model->id;?>" <?php echo $sel;?>><?php echo lang_key($model->name);?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="<?php echo $css_class;?>">
                                    <div class="form-group">
                                        <label for="input-11"><?php echo lang_key('condition');?></label>
                                        <select name="condition" id="condition" class="form-control chosen-select">
                                            <option data-name="" value=""><?php echo lang_key('select_condition');?></option>
                                            <?php foreach ($conditions as $option) {
                                                $sel = ($option==set_value('condition'))?'selected="selected"':'';
                                            ?>
                                                <option data-name="<?php echo lang_key($option);?>" value="<?php echo $option;?>" <?php echo $sel;?>><?php echo lang_key($option);?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div style="clear:both"></div>
                                
                                <?php if($filter_type=='advanced_options_with_country_state'){?>

                                <div class="<?php echo $css_class;?>">
                                    <div class="form-group">
                                        <label for="input-11"><?php echo lang_key('select_country');?></label>
                                        <select name="country" id="country" class="form-control chosen-select">
                                            <option data-name="" value=""><?php echo lang_key('select_country');?></option>
                                            <?php foreach (get_all_locations_by_type('country')->result() as $row) {
                                                $sel = ($row->id==set_value('country'))?'selected="selected"':'';
                                                ?>
                                                <option data-name="<?php echo $row->name;?>" value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo lang_key($row->name);?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <?php if($state_active=='yes'){?>
                                <div class="<?php echo $css_class;?>">
                                    <div class="form-group">
                                        <label for="input-11"><?php echo lang_key('select_state');?></label>
                                        <select name="state" id="state" class="form-control chosen-select">
                                            
                                        </select>
                                    </div>
                                </div>
                                <?php }?>

                                <div class="<?php echo $css_class;?>">
                                    <div class="form-group">
                                        <label for="input-11"><?php echo lang_key('select_city');?></label>
                                        <?php $city_field_type = get_settings('content_settings', 'city_dropdown', 'autocomplete'); ?>
                                        <input type="hidden" id="selected_city" value="<?php echo(set_value('selected_city')!='')?set_value('selected_city'):'';?>">
                                        <select name="city" id="city_dropdown" class="form-control chosen-select">                                        
                                            <option value=""><?php echo lang_key('select_one');?></option>
                                        </select>
                                    </div>
                                </div>
                                <?php }?>

                                <div class="<?php echo $css_class;?>">
                                    <div class="form-group">
                                        <label for="input-11"><?php echo lang_key('fuel_type');?></label>
                                        <select name="fuel_type" id="fuel_type" class="form-control chosen-select">
                                            <option data-name="" value=""><?php echo lang_key('select_fuel_type');?></option>
                                            <?php foreach ($fueltypes as $option) {
                                                $v = (set_value('fuel_type')!='')?set_value('fuel_type'):'';
                                                $sel = ($v==$option)?'selected="selected"':'';

                                            ?>
                                                <option data-name="<?php echo lang_key($option);?>" value="<?php echo $option;?>" <?php echo $sel;?>><?php echo lang_key($option);?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <?php if($state_active=='yes' && $filter_type=='advanced_options_with_country_state'){?>
                                        <div style="clear:both"></div>
                                <?php }?>

                                <div class="<?php echo $css_class;?>">
                                    <label><?php echo lang_key('mileage_range'); ?></label>
                                    <input type="text" id="mileage_slider" name="mileage_slider" value="" />
                                </div>

                                <div class="<?php echo $css_class;?>">
                                    <label><?php echo lang_key('price_range'); ?></label>
                                    <input type="text" id="price_slider" name="price_slider" value="" />
                                </div>


                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i>&nbsp; <?php echo lang_key('search_cars'); ?></button>
                                    </div>
                                </div>


                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo theme_url();?>/assets/jquery-ui/jquery-ui.js" defer></script>

<link href="<?php echo theme_url();?>/assets/css/select2.css" rel="stylesheet">
<script src="<?php echo theme_url();?>/assets/js/select2.js"></script>

<?php
$isSsl = (strpos('-'.base_url(), 'https://')>0)?'1':'0';
?>
<script type="text/javascript">

    var ua = navigator.userAgent.toLowerCase();
    var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");

    // added on version 1.5
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    var isSsl = '<?php echo $isSsl;?>';
    //end

    jQuery(window).resize(function(){
        if(!isAndroid) {
            jQuery('.chosen-select').select2({
                theme: "classic"
            });
        }
    });

    $(document).ready(function(){
        if(!isAndroid) {
            jQuery('.chosen-select').select2({
                theme: "classic"
            });
        }

        jQuery('#select-brand').change(function(){
            var val = jQuery(this).val();
            jQuery.post(
                "<?php echo site_url('show/get_models_ajax');?>/",
                {brand: val},
                function(html){
                    
                    jQuery('#select-model').empty();
                    jQuery('#select-model').html(html);
                },
                "html"
            );
        }).change();

        
        var distance_unit = '<?php echo lang_key(get_settings("content_settings", "show_distance_in", "miles")); ?>';

        jQuery("#slider-price-sell").slider({

            min: <?php echo $this->config->item('min_distance');?>,

            max: <?php echo $this->config->item('max_distance');?>,

            value: <?php echo $this->config->item('default_distance');?>,

            slide: function (event, ui) {

                jQuery("#price-slider-sell").val(ui.value);
                jQuery("#amount").html( ui.value + ' ' + distance_unit );

            }

        });
        jQuery("#amount").html(jQuery( "#slider-price-sell" ).slider( "value") + ' ' + distance_unit);

        $("#mileage_slider").ionRangeSlider({
            min: 0,
            max: 10000,
            type: 'double',
            prefix: "<?php echo lang_key(get_settings('content_settings','mileage_unit','miles'))?>",
            maxPostfix: "+",
            prettify: false,
            hasGrid: true
        });

        var min_price=0,max_price=500;
        $.ajax({
          dataType: "json",
          url: "<?php echo site_url('show/get_min_max_car_price_ajax');?>/",
          success: function(data) {
              min_price = data['min_price'];
              max_price = data['max_price'];
              $("#price_slider").ionRangeSlider({
                  min: min_price,
                  max: max_price,
                  type: 'double',
                  prefix: "<?php echo $CI->session->userdata('system_currency'); ?>",
                  maxPostfix: "+",
                  prettify: false,
                  hasGrid: true
              });
          },
          error: function() {
            $("#price_slider").ionRangeSlider({
                min: 0,
                max: 5000,
                type: 'double',
                prefix: "<?php echo $CI->session->userdata('system_currency'); ?>",
                maxPostfix: "+",
                prettify: false,
                hasGrid: true
            });
          }
        });            
    });

    // updated on version 1.5
    function findLocation()
    {
        if(isChrome==true && isSsl==0)
        {
            var r = confirm("<?php echo lang_key('location_chorome_msg')?>");
            if(r==true)
            {
                $.get("//ipinfo.io", function(response) {
                var arr = response.loc.split(",");

                        $('#geo_lat').val(arr[0]);
                        $('#geo_lng').val(arr[1]);

                }, "jsonp");
                
            }
        }
        else
        {
            if(!!navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(position) {

                    $('#geo_lat').val(position.coords.latitude);
                    $('#geo_lng').val(position.coords.longitude);


                });

            } else {
                alert('No Geolocation Support.');
            }            
        }
    }
    //end

    $(document).ready(function(){

        var site_url = '<?php echo site_url();?>';
        jQuery('#country').change(function(){
            // jQuery('#city').val('');
            // jQuery('#selected_city').val('');
            var val = jQuery(this).val();
            
            var loadUrl = site_url+'/show/get_locations_by_parent_ajax/'+val;

            jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    <?php if($state_active=='yes'){?>
                    jQuery('#state').html(responseText);
                    var sel_country = '<?php echo (set_value("country")!='')?set_value("country"):"";?>';
                    var sel_state   = '<?php echo (set_value("state")!='')?set_value("state"):"";?>';
                    if(val==sel_country)
                    jQuery('#state').val(sel_state);
                    else
                    jQuery('#state').val('');
                    jQuery('#state').focus();
                    jQuery('#state').trigger('change');
                    <?php }else{?>
                    var sel_country = '<?php echo (set_value("country")!='')?set_value("country"):"";?>';
                    var sel_city   = '<?php echo (set_value("selected_city")!='')?set_value("selected_city"):"";?>';
                    var city   = '<?php echo (set_value("city")!='')?set_value("city"):"";?>';
                    if(city_field_type=='dropdown')
                    populate_city(val); //populate the city drop down
                    if(val==sel_country)
                    {
                        jQuery('#selected_city').val(sel_city);
                        jQuery('#city').val(city);
                    }
                    else
                    {
                        jQuery('#selected_city').val(sel_city);
                        jQuery('#city').val('');            
                    }
                    <?php }?>

                }
            );
         }).change();

        var city_field_type =  'dropdown' ;

            jQuery('#state').change(function(){
                <?php if($state_active=='yes'){?>
                var val = jQuery(this).val();
                var sel_state   = '<?php echo (set_value("state")!='')?set_value("state"):"";?>';
                var sel_city   = '<?php echo (set_value("selected_city")!='')?set_value("selected_city"):"";?>';
                var city   = '<?php echo (set_value("city")!='')?set_value("city"):"";?>';
                
                if(city_field_type=='dropdown')
                populate_city(val); //populate the city drop down

                if(val==sel_state)
                {
                    jQuery('#selected_city').val(sel_city);
                    jQuery('#city').val(city);
                }
                else
                {
                    jQuery('#selected_city').val('');
                    jQuery('#city').val('');            
                }
                <?php }?>

            }).change();

    });

function populate_city(parent) {
    var site_url = '<?php echo site_url();?>';
    var loadUrl = site_url+'/show/get_city_val_dropdown_by_parent_ajax/'+parent;
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('#city_dropdown').html(responseText);
                var sel_city   = '<?php echo (set_value("city")!='')?set_value("city"):"";?>';
                jQuery('#city_dropdown').val(sel_city);
            }
        );
}
</script>
<!-- property search big form -->