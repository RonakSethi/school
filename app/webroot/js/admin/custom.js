jQuery(document).ready(function(){
    //FOR Time Range Slider
    timepicker() 
    
    // Select To tags 
      jQuery(".multipletag").select2();
   
     
	// for admin product autosearch
	jQuery(document).on('keyup', '#search', function(){
		var keywords = $(this).val();
		var sort = $('#productSort').val();
		$('#search_bar').html('<img src="'+SITE_URL+'img/ajax-loader.gif">');
		jQuery.ajax({
			url:SITE_URL+'admin/products/search_product',
			type:'post',
			dataType:'json',
			data:{keywords:keywords,orderBy:sort},
			success: function(response){
				$('#search_bar').html('<i class="fa fa-search"></i>');
				$('#product_container').html(response.html);
				if(response.total_pages < 2){
						$('#load_more').hide();
				}else{
					$('#load_more').show();
				}
			}
		});
	});
	//end
	
	//product sort
		jQuery(document).on('click', '.order', function(){
			window.location.href = $(this).attr('rel');
		});
	//end
	
	//load more product
		var page = '2';
		jQuery(document).on('click', '#load_more', function(){
			var keywords = $(this).val();
			var sort = $('#productSort').val();
			$(this).text('loading...');
			jQuery.ajax({
				url:SITE_URL+'admin/products/search_product/page:'+page,
				dataType:'json',
				type:'post',
				data:{keywords:keywords,orderBy:sort},
				success: function(response){
					$('#load_more').text('Load More');	
					$('#product_container').append(response.html);
					if(response.total_pages == page){
						$('#load_more').hide();
						return false;
					}
					page++;
				}
			});
		});	
	//end
	
	//for select all product 
		$(document).on('click','.checkProduct',function(){
			if($(this).is(':checked')){
				$(':checkbox').prop('checked', true);
				$('.update_cost').attr('disabled',false);
				$('.btn-submit').attr('disabled', false);	
			}else{
				$(':checkbox').prop('checked', false);
				$('.update_cost').attr('disabled',true);
				$('.btn-submit').attr('disabled', true);
				
			}
		});
	//end
	
	$(document).on('click','.select_check',function(){
		var val = $(this).val();
		var numOfCheck = $('.select_check:checkbox:checked').length;
		var totalCheckboxes = $('.select_check:checkbox').length;
		if($(this).is(':checked')){
			
			$('#input'+val).attr('disabled',false);
		}else{
			
			$('#input'+val).attr('disabled',true);
		}
		
		if(numOfCheck < 1){
			$('.btn-submit').attr('disabled', true);
		}else{
			$('.btn-submit').attr('disabled', false);
		}
		
		if(numOfCheck == totalCheckboxes){
			$('.checkProduct').prop('checked',true);
		}else{
			$('.checkProduct').prop('checked', false);
		}
		
	});
	
	//select product cost validation
	var is_checked = 0
	$(document).on('keyup','.update_cost',function(){
		var relId = $(this).attr('rel');
		$(this).removeClass('errorField');
		if($(this).val() == ''){
			console.log($(this).attr('rel'));
			if($('#checkbox'+relId).is(':checked')){
				is_checked = 1;
				$('#checkbox'+relId).prop('checked',false);
				$('#checkbox'+relId).attr('disabled',true);
			}
			$(this).addClass('errorField');
		}else{
			if(is_checked){
				$('#checkbox'+relId).prop('checked',true);
			}
			$('#checkbox'+relId).attr('disabled',false);
		}
	});
	
	//end
	
	
	$(".update_cost").keypress(function(event) {
			// Backspace, tab, enter, end, home, left, right
			// We don't support the del key in Opera because del == . == 46.
			var controlKeys = [8, 9, 13, 35, 36, 37, 39];
			// IE doesn't support indexOf
			var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
			// Some browsers just don't raise events for control keys. Easy.
			// e.g. Safari backspace.
		  if (!event.which || // Control keys in most browsers. e.g. Firefox tab is 0
			  (49 <= event.which && event.which <= 57) || // Always 1 through 9
			  (48 == event.which && $(this).attr("value")) || // No 0 first digit
			  isControlKey) { // Opera assigns values for control keys.
			return;
		  } else {
			event.preventDefault();
		  }
		});
	
	var numOfCheck = $('.select_check:checkbox:checked').length;
	var totalCheckboxes = $('.select_check:checkbox').length;
	
	if(numOfCheck == totalCheckboxes){
		$('.checkProduct').prop('checked',true);
	}
	
	if(numOfCheck < 1){
		$('.btn-submit').attr('disabled', true);
	}
	
	$(document).on('click','.distributor_add_product',function(){
		var distributor_id = $(this).attr('rel');
		$('#role_type').val('3');
		$('#distributer_id').val(distributor_id);
		$('.productContains').hide();
		jQuery.ajax({
			url:SITE_URL+'admin/distributers/distributer_product/'+distributor_id,
			type:'post',
			dataType:'json',
			success: function(response){
				$('.productContains').show();
				$("#ProductAdminIndexForm").attr('action',SITE_URL+'admin/distributers/index/'+response.user_id)
				$('.productContains').html(response.html);
				$("#disId").val(response.user_id);
				var numOfCheck = $('.select_check:checkbox:checked').length;
				var totalCheckboxes = $('.select_check:checkbox').length;
	
				if(numOfCheck == totalCheckboxes){
					$('.checkProduct').prop('checked',true);
				}
	
				if(numOfCheck < 1){
					$('.btn-submit').attr('disabled', true);
				}else{
					$('.btn-submit').attr('disabled', false);
				}
			}
		});
	});
	
	$(document).on('keyup','#searchProductList',function(){
		$('.btn-white').html('<img src="'+SITE_URL+'img/ajax-loader.gif">');
		var keywords = $(this).val();
		var role_type = $('#role_type').val();
		var distributor_id = $('#distributer_id').val();
		jQuery.ajax({
			url:SITE_URL+'admin/products/search_product_listing/'+role_type+'/'+distributor_id,
			type:'post',
			data:{keywords:keywords},
			dataType:'json',
			success: function(response){
				$('.btn-white').html('<i class="fa fa-search"></i>');
				$('.productContains').html(response.html);
			}
		});
	});
	
	//admin upload image
	$(document).on('click','#Uimg', function(){
		$('.admin_image').trigger('click');
	});
	$(document).on('change','.admin_image',function(){
		readURL(this);
	});
	//end
	$(document).on('change','.uploadImage',function(){
		 var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $(this).val('');
			alert("Only formats are allowed : "+fileExtension.join(', '));
        }
	});
	
	
	 $('.nospace').bind('input', function(){
		$(this).val(function(_, v){
		return v.replace(/\s+/g, '');
		});
	});
	
	$(document).on('click','#order_label',function(){
		$(this).hide();
		$('#updateStatus').show();
	});
	
	$(document).on('change','#updateStatus',function(){
		var value = $(this).val();
		var id = $(this).attr('rel');
		$.ajax({
			url:SITE_URL+'admin/orders/update_status/'+id,
			type:'post',
			dataType:'json',
			data:{data:value},
			success:function(){
				if(value == 1){
					$('#order_label').addClass('label-success').removeClass('label-primary').text('Delivered');
				}else{
					$('#order_label').addClass('label-primary').removeClass('label-success').text('Proceed');
				}
				$('#order_label').show();
				$('#updateStatus').hide();
			}
				
				
		})
	});
	
});

var cancelRedirection = function(controller,action){
    window.location.href  = AppScript.SITE_URL+'admin/'+controller+'/'+action ;
}

//admin upload images
	
	function readURL(input) {
		console.log(input.files);
        if (input.files && input.files[0]) {
			if ( $.browser.safari ) {
				alert('Your browser doesn\'t support the File upload ! Please try different Browser');
			}else{
				var file_size = input.files[0].size;
			}
			var reader = new FileReader();
			console.log(file_size);
			
			if($.inArray(input.files[0].type, ['image/gif','image/png','image/jpg','image/jpeg']) == -1) {
				alert('You can upload only images (jpg,png,gif)!');
			  return false;
			}			
				
			if(file_size>3145728) {
				alert('Max fle size is 3 mb allowed');
				return false;
			}	
            reader.onload = function (e) {
				//Initiate the JavaScript Image object.
			
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
					
                    image.onload = function () {
                        //Determine the Height and Width.
                        var height = this.height;
                        var width = this.width;
                        adminImgUpload(e.target.result);
                    };
					
					
				
			  
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
	
function adminImgUpload(image){
	$.ajax({
		url:SITE_URL+'admin/users/upload_image',
		data:{image:image},
		dataType:'json',
		type:'POST',
		success: function(response){
			if(response.image != ''){
				$('.img-circle').attr('src',response.image);
			}
			
		}
	});
}

function timepicker(){
    $("#slider-range").slider({
    range: true,
    min: 0,
    max: 1440,
    step: 15,
    values: [00, 1500],
    slide: function (e, ui) {
        var hours1 = Math.floor(ui.values[0] / 60);
        var minutes1 = ui.values[0] - (hours1 * 60);

        if (hours1.length == 1) hours1 = '0' + hours1;
        if (minutes1.length == 1) minutes1 = '0' + minutes1;
        if (minutes1 == 0) minutes1 = '00';
       
        if (hours1 == 0) {
            hours1 = 12;
            minutes1 = minutes1;
        }



        $('.slider-time').html(hours1 + ':' + minutes1);
        $('#studio_start_time').val(hours1 + ':' + minutes1);
        $('#se_start_time').val(hours1 + ':' + minutes1);

        var hours2 = Math.floor(ui.values[1] / 60);
        var minutes2 = ui.values[1] - (hours2 * 60);

        if (hours2.length == 1) hours2 = '0' + hours2;
        if (minutes2.length == 1) minutes2 = '0' + minutes2;
        if (minutes2 == 0) minutes2 = '00';
     

        $('.slider-time2').html(hours2 + ':' + minutes2);
        $('#studio_end_time').val(hours2 + ':' + minutes2);
        $('#se_end_time').val(hours2 + ':' + minutes2);
    }
});
}
function timepicker_old(){
    $('.timepicker').timepicker({ 
        'showDuration': true,
        'timeFormat': 'H:i:s',
        'step':'15',
        
    });
}

//Google Map set location 
 function getmapByLocationAndMarker(prelat,prelng) {
//      if(isequalto){
//         
//         var preLatlng = new google.maps.LatLng(prelat, prelng);
//         markers.setPosition(preLatlng)
//         var map = new google.maps.Map(document.getElementById('map'), {
//            center: {lat: lat, lng: lng},
//            zoom: 13,
//            mapTypeId: google.maps.MapTypeId.ROADMAP,
//            draggable: true,
//            disableDefaultUI: true
//        });
//         map.setCenter(markers.getPosition());
//            cityCircle.setCenter(markers.getPosition())
//            map.setZoom(12);
//            document.getElementById('lat').value=cmarker.lat();
//            document.getElementById('lng').value=cmarker.lng();
//            getAddress(preLatlng)
//     }
       geocoder = new google.maps.Geocoder();
        var lat = prelat
        var lng = prelng
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lat, lng: lng},
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
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
            map.setZoom(12);
           
        })
        var input = document.getElementById('address');
        var options = {
            types: ['(cities)']
                    //componentRestrictions: {country: 'au'}
        };

        var searchBox = new google.maps.places.Autocomplete(input, options);
        searchBox.bindTo('bounds', map);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
        map.addListener('bounds_changed', function () {
            cmarker = map.getCenter()
            markers.setPosition(cmarker);
            cityCircle.setCenter(cmarker)
            map.setZoom(12);
            console.log(cmarker)
            document.getElementById('lat').value=cmarker.lat();
                document.getElementById('lng').value=cmarker.lng();
            getAddress(cmarker)
        });
        

        function getAddress(latLng) {
            geocoder.geocode({'latLng': latLng},
            function (results, status) {
                
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        document.getElementById("address").value = results[0].formatted_address;
                    }
                    else {
                        document.getElementById("address").value = "No results";
                    }
                }
                else {
                    document.getElementById("address").value = status;
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
            map.setZoom(12);

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

$('body').on('click', '.status-link i', function() {
	var $this = $(this);
	var $parnet = $(this).parent();
	var dataError = $(this).clone();
	if ($(this).hasClass('fa-minus-square')) {
		var dataSuccess = '<i class="fa fa-check-square" title="Active"></i>';
		var status = 1;
	} else {
		var dataSuccess = '<i class="fa fa-minus-square" title="Deactive"></i>';
		var status = 0;
	}
	var data = {status: status, model: $parnet.attr('data-model'), model_id: $parnet.attr('data')};
	$.ajax({
		type: "POST",
		url: SITE_URL + 'ajax/status',
		data: data,
		async: false,
		beforeSend: function() {
			$parnet.html('<img src="' + SITE_URL + 'img/small/ajax-loader.gif" >');
		},
		success: function(data) {
			if (data) {
				$parnet.html(dataSuccess);
			} else {
				$parnet.html(dataError);
			}
		}
	});
})

$('body').on('click', '.verify-link i', function() {
	var $this = $(this);
	var $parnet = $(this).parent();
	var dataError = $(this).clone();
	if ($(this).hasClass('ion-android-close')) {
		var dataSuccess = '<i class="ion-android-checkmark" title="Active"></i>';
		var status = 1;
	} else {
		var dataSuccess = '<i class="ion-android-close" title="Deactive"></i>';
		var status = 0;
	}
	var data = {status: status, model: $parnet.attr('data-model'), model_id: $parnet.attr('data')};
	$.ajax({
		type: "POST",
		url: SITE_URL + 'ajax/verify',
		data: data,
		async: false,
		beforeSend: function() {
			$parnet.html('<img src="' + SITE_URL + 'img/small/ajax-loader.gif" >');
		},
		success: function(data) {
			if (data) {
				$parnet.html(dataSuccess);
			} else {
				$parnet.html(dataError);
			}
		}
	});
})
//end