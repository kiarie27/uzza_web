<style>
    #classify-main-map{

        height: 450px;
    }
    #classify-main-map img { max-width: none; }
    .top-bar{
      color: #000 !important;
    }
    .top-bar a{
      color: #000;
    }
    .top-bar .tb-social i{  
      color: #000 !important;
    }
    @media only screen and (max-width : 510px) {
      .tb-language a{
        color: #fff;
      }
    }
    @media only screen and (min-width : 511px) {
        .tb-language a{
            color: #000 !important;
        }
    }
</style>

<?php $posts = get_all_car_map_data() ?>
<section id="big-map">
    <div id="classify-main-map"></div>
</section>

<?php
// added on version 1.6
$map_api_key = get_settings('banner_settings','map_api_key','');
$api_key_text = ($map_api_key!='')?"&key=$map_api_key":'';
?>
<script src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places<?php echo $api_key_text;?>"></script>
<script src="<?php echo theme_url();?>/assets/js/markercluster.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map-icons.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map_config.js"></script>
<script type="text/javascript">

    var myLatitude = parseFloat('<?php echo get_settings("banner_settings","map_latitude", 37.2718745); ?>');
    var myLongitude = parseFloat('<?php echo get_settings("banner_settings","map_longitude", -119.2704153); ?>');

    var map;
    var markers = [];
    function initialize() {



        var zoomLevel = parseInt('<?php echo get_settings("banner_settings","map_zoom",8); ?>');
        var map_data = <?php echo json_encode($posts); ?>;

        var myLatlng = new google.maps.LatLng(myLatitude,myLongitude);
        var mapOptions = {
            scrollwheel: false,
            zoom: zoomLevel,
            center: myLatlng,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            panControl: true,
            panControlOptions: {
                position: google.maps.ControlPosition.RIGHT_TOP
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: MAP_STYLE
        }

        map = new google.maps.Map(document.getElementById('classify-main-map'), mapOptions);

        var marker, i;
        var infoContentString = [];
        var infowindow = new google.maps.InfoWindow({
            content: "Hello World"
        });


        if(map_data.posts.length > 0){
            for (i = 0; i < map_data.posts.length; i++) {
                var marker_label = '<img src="'+map_data.posts[i].fa_icon+'" class="map-marker"/>';
                marker = new Marker({
                    position: new google.maps.LatLng(map_data.posts[i].latitude, map_data.posts[i].longitude),
                    map: map,
                    map_icon_label: marker_label,
                    title: map_data.posts[i].post_title,
                    zIndex: 9,
                    icon: {
                        path: SQUARE_PIN,
                        fillColor: map_data.posts[i].fa_color,
                        fillOpacity: 1,
                        strokeColor: '',
                        strokeWeight: 0,
                        scale: 1/3
                    }

                });


                infoContentString[i] = '<div class="clearfix"></div>'+
                                        '<div class="infowindow-container">'+
                                            '<div class="info-image-holder">'+
                                                '<img src="'+map_data.posts[i].featured_image_url+'">'+
                                            '</div>'+
                                            '<div class="detail-holder">'+
                                                '<h4>'+map_data.posts[i].post_title+'</h4>'+
                                                '<div class="infowindow-category">'+map_data.posts[i].parent_category+'</div>'+
                                                '<div class="infowindow-price"><?php echo lang_key("price");?>: '+map_data.posts[i].price+'</div>'+
                                                '<a href="'+map_data.posts[i].detail_link+'" class="infowindow-detail-link"><?php echo lang_key("detail");?></a>'+
                                            '</div>'+
                                            '<div style="clear:both"></div>'+
                                        '</div>';

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(infoContentString[i]);
                        infowindow.setOptions({maxWidth:300,zIndex:9999});
                        infowindow.open(map, marker);
                        map.setCenter(this.getPosition());

                    }
                })(marker, i));
//                createMarkerButton(marker, map_data.posts[i]);
                markers.push(marker);
//                infoContentString.push(contentString);
            }
            var markerCluster = new MarkerClusterer(map, markers);
        }
    }

    google.maps.event.addDomListener(window, 'load', initialize);

</script>