<script type="text/javascript">
    function getmapByLocationAndMarker(prelat, prelng) {

        geocoder = new google.maps.Geocoder();
        var lat = prelat
        var lng = prelng
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lat, lng: lng},
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            draggable: true,
            disableDefaultUI: true
        });
        var myLatlng = new google.maps.LatLng(lat, lng);
        markers = new google.maps.Marker({
            position: myLatlng,
            map: map,
            draggable: true
        });

        var cityCircle = new google.maps.Circle({
            strokeColor: '#005773',
            strokeOpacity: 0.2,
            strokeWeight: 2,
            fillColor: '#0097c6',
            fillOpacity: 0.2,
            map: map,
            center: myLatlng,
            radius: 5000
        });



        google.maps.event.addListener(markers, 'dragend', function () {
            console.log('aaaaaaar')
            map.setCenter(markers.getPosition());
            cityCircle.setCenter(markers.getPosition())
            map.setZoom(16);

        })
        var input = document.getElementById('address');
        var options = {
            types: ['(cities)']
                    //componentRestrictions: {country: 'au'}
        };

        var searchBox = new google.maps.places.Autocomplete(input);
        //var searchBox = new google.maps.places.Autocomplete(input, options);
        searchBox.bindTo('bounds', map);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
        map.addListener('bounds_changed', function () {
            cmarker = map.getCenter()
            markers.setPosition(cmarker);
            cityCircle.setCenter(cmarker)
            map.setZoom(16);
            console.log(cmarker)

            document.getElementById('RouteLat').value = cmarker.lat();
            document.getElementById('RouteLng').value = cmarker.lng();

            //document.getElementById('Routelocation').value=cmarker.lat()+','+cmarker.lng();
            //alert(cmarker)

            getAddress(cmarker)
        });


        function getAddress(latLng) {
            geocoder.geocode({'latLng': latLng},
            function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        document.getElementById("address").value = results[0].formatted_address;
                        document.getElementById("RouteFormattedAddress").value = results[0].formatted_address;

                    }
                    else {
                        document.getElementById("address").value = "No results";
                    }
                }
                else {
                    document.getElementById("address").value = status;
                    document.getElementById("RouteFormattedAddress").value = status;
                }
            });
        }

        searchBox.addListener('place_changed', function () {
            var places = searchBox.getPlace();

            if (places.length == 0) {
                return;
            }
            var bounds = new google.maps.LatLngBounds();
            var cmarker = myLatlng;

            if (places.geometry.viewport) {
                bounds.union(places.geometry.viewport);
            } else {
                bounds.extend(places.geometry.location);
            }

            map.fitBounds(bounds);
            cmarker = map.getCenter()
            markers.setPosition(cmarker);
            cityCircle.setCenter(cmarker)
            map.setZoom(16);

        })

        /* map.addListener('center_changed', function() {
         
         window.setTimeout(function() {
         cmarker = map.getCenter()
         markers.setPosition(cmarker);
         cityCircle.setCenter(cmarker)
         //map.setZoom(12);
         $scope.$apply(function(){
         //console.log(cmarker.lat())
         $scope.model.defaultLat = cmarker.lat();
         $scope.model.defaultLong = cmarker.lng();
         });
         }, 1000);
         }); */

        map.addListener('click', function (event) {
            map.setCenter(event.latLng);
            cmarker = map.getCenter()
            //markers.setPosition(cmarker);
            //cityCircle.setCenter(cmarker)
            //map.setZoom(12);

        });
    }
</script>

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            
              <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title"><?php echo $title_for_layout; ?></h4>
                    <ol class="breadcrumb">
                        <li>
                            <?php echo $this->html->link('Dashboard',array('admin'=>true,'controller'=>'users','action'=>'dashboard'))?>
                        </li>
                        <li class="active"><?php echo $title_for_layout; ?></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                       
                        <div class="panel-body">
                            <?php if ($this->Session->read('Message')) : ?>
                                <div class="alert <?php echo $this->Session->read('msg_type'); ?> fade in">
                                    <button type="button" class="close close-sm" data-dismiss="alert">
                                        <i class="fa fa-times"></i>
                                    </button>                                   
                                    <?php echo $this->Session->flash(); ?>  
                                </div>   
                            <?php endif; ?>
                            <div class="form">
                                <?php echo $this->Form->create("Route", array("action" => "add", "method" => "Post", "class" => "cmxform form-horizontal ", "id" => "addRoute", 'enctype' => 'multipart/form-data')); ?>

                                <div class="form-group ">
                                    <label for="username" class="control-label col-lg-3">Route Name *</label>
                                    <div class="col-lg-6">
                                        <?php echo $this->Form->select('Route.bus_id', $catList, array('class' => ' form-control', 'label' => true, 'div' => false, 'empty' => 'Select Route', 'default' => '4')); ?>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label for="username" class="control-label col-lg-3">Sequence #*</label>
                                    <div class="col-lg-6">
                                        <?php echo $this->Form->input('Route.oid', array('class' => ' form-control', 'label' => false, 'div' => false)) ?>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label for="username" class="control-label col-lg-3">Bus Stop Name *</label>
                                    <div class="col-lg-6">
                                        <?php //echo $this->Form->input('Route.title', array('class' => ' form-control', 'label' => false, 'div' => false)) ?>
                                        <div><input name="data[Route][title]" class="form-control valid" id="address" onpaste="return false" required="required" style="z-index: 0; position: absolute; top: -10px; left: 0px; width:450px;" placeholder="Enter a location" autocomplete="off" type="text"></div>
                                        <?php
                                        echo '<div class="google_data">';
                                        echo $this->Form->hidden('Route.name', array('label' => false, 'div' => false, 'name' => 'name'));
                                        echo $this->Form->hidden('Route.lat', array('label' => false, 'div' => false, 'name' => 'lat'));
                                        echo $this->Form->hidden('Route.lng', array('label' => false, 'div' => false, 'name' => 'lng'));
                                        echo $this->Form->hidden('Route.location', array('label' => false, 'div' => false, 'name' => 'location'));
                                        echo $this->Form->hidden('Route.formatted_address', array('label' => false, 'div' => false, 'name' => 'formatted_address'));
                                        echo $this->Form->hidden('Route.country_short', array('label' => false, 'div' => false, 'name' => 'country_short'));
                                        echo $this->Form->hidden('Route.postal_code', array('label' => false, 'div' => false, 'name' => 'postal_code'));
                                        echo $this->Form->hidden('Route.locality', array('label' => false, 'div' => false, 'name' => 'locality'));
                                        echo $this->Form->hidden('Route.country', array('label' => false, 'div' => false, 'name' => 'country'));
                                        echo $this->Form->hidden('Route.administrative_area_level_1', array('label' => false, 'div' => false, 'name' => 'administrative_area_level_1'));
                                        echo '</div>'
                                        ?>
                                    </div>
                                </div>
                                <div class='googlemapframe' id="map" style="width:850px;height:600px; margin-left:130px;"></div>

                                <div class="form-group ">
                                    <label for="active" class="control-label col-lg-3">Active</label>
                                    <div class="col-sm-9 icheck ">
                                        <div class="flat-yellow single-row">
                                            <div class="radio ">
                                                <?php
                                                $options = array(ACTIVE => 'Active', INACTIVE => 'Inactive');
                                                $attributes = array('legend' => false, 'value' => ACTIVE, 'separator' => '&nbsp;&nbsp;', 'label' => array('class' => "label_class"));
                                                echo $this->Form->radio('Route.status', $options, $attributes);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-lg-offset-3 col-lg-6">
                                        <?php echo $this->Form->submit('Save', array('class' => ' btn btn-primary', 'label' => false, 'div' => false, 'id' => "user_submit", 'value' => "Save")); ?>
                                        <input class="btn btn-default" name="cancel" type="button" value="Cancel" onclick="cancelrediraction('routes', 'index');">
                                    </div>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
         </div> <!-- container -->

    </div> <!-- content -->

    <footer class="footer">
        © 2016. All rights reserved.
    </footer>

</div>
<script type="text/javascript">
    window.onload = function () {
        var latitude = 26.88529193798131
        var longitude = 75.79055784999991
        getmapByLocationAndMarker(latitude, longitude)
    }
</script>