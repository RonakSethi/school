<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                         <span class="title"> <?php echo $pageHeading; ?> ---- <?php echo $bus_number['Bus']['bus_number']; ?></span>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
       <style>
	  #map-canvas {
    height: 100%;
    margin: 0;
    padding: 0
}
	   </style>
<script type="text/javascript">
    
    var map = undefined;
    var marker = undefined;
    var position = [<?php echo $lat2;?>,<?php echo $long2;?>];
    
	var car = "M17.402,0H5.643C2.526,0,0,3.467,0,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759c3.116,0,5.644-2.527,5.644-5.644 V6.584C23.044,3.467,20.518,0,17.402,0z M22.057,14.188v11.665l-2.729,0.351v-4.806L22.057,14.188z M20.625,10.773 c-1.016,3.9-2.219,8.51-2.219,8.51H4.638l-2.222-8.51C2.417,10.773,11.3,7.755,20.625,10.773z M3.748,21.713v4.492l-2.73-0.349 V14.502L3.748,21.713z M1.018,37.938V27.579l2.73,0.343v8.196L1.018,37.938z M2.575,40.882l2.218-3.336h13.771l2.219,3.336H2.575z M19.328,35.805v-7.872l2.729-0.355v10.048L19.328,35.805z";
var icon = {
  path: car,
  scale: .7,
  strokeColor: 'white',
  strokeWeight: .10,
  fillOpacity: 1,
  fillColor: '#404040',
  offset: '5%',
  // rotation: parseInt(heading[i]),
  anchor: new google.maps.Point(10, 25) // orig 10,50 back of car, 10,0 front of car, 10,25 center of car
};

   function init() 
	{
			$.ajax({
		   type: 'GET',
			url:"/services/busmapdata?bus_id=<?php echo $id;?>", 
			sync: true,
			success: function(data)
			{
				var resultSet = $.parseJSON(data).resultSet;
				var resultSet1 = $.parseJSON(data).resultSet1;
				console.log(resultSet[0]+resultSet[1]);
				console.log(resultSet1[0]+resultSet1[1]);
				
				transition(resultSet1[0],resultSet1[1])
			}
		   });
	}
   
    function initialize() {
            
        var latlng = new google.maps.LatLng(position[0], position[1]);
        var myOptions = {
            zoom: 17,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
        marker = new google.maps.Marker({
            position: latlng,
            map: map,
			icon: '/map.png',
            title: "Your current location!"
        });
    
        google.maps.event.addListener(map, 'click', function(me) {
            var result = [me.latLng.lat(), me.latLng.lng()];
            //transition(result);
        });
    }
    
    var numDeltas = 100;
    var delay = 10; //milliseconds
    var i = 0;
    var deltaLat;
    var deltaLng;
    function transition(a,b){
        i = 0;
        //deltaLat = (result[0] - position[0])/numDeltas;
        //deltaLng = (result[1] - position[1])/numDeltas;
		//alert(deltaLat+"|"+deltaLng)
		deltaLat = a;
        deltaLng = b;
        moveMarker();
    }
    
    function moveMarker(){
        position[0] = deltaLat;
        position[1] = deltaLng;
		
		//alert(position[0]+"|"+position[1])
		
        var latlng = new google.maps.LatLng(position[0], position[1]);
		marker.setPosition(latlng);
		map.setCenter(latlng)
		
        
        if(i!=numDeltas){
            i++;
            setTimeout(moveMarker, delay);
        }
    }
    
window.onload = initialize; 

setInterval(function(){  init(); }, 5000); 
</script>
<div id="map_canvas" style="width: 1000px; height: 800px">
</div>


                    
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>
