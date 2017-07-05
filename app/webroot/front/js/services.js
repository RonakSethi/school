angular.module('fundraiser.services', [])

.factory('$ajax', ['$http','$interval','$rootScope', function ($http,$interval,$rootScope) {

	return {
		postData: function (urlPath, data, successCallback) {
			if(urlPath == 'get_project_list/page:1' || urlPath == 'get_product_detail' || urlPath == 'checkout'){
				$rootScope.apiLoader = true;
			}else{
				$rootScope.apiLoader = false;
			}
			
			var ajaxRunning = $http({
				method: 'POST',
				url: siteUrl+'services/'+urlPath,
				data: data,
				dataType: "JSON",
				async: true,
			}).then(function (data) {
				$rootScope.apiLoader = false;
				if(data.data.replyCode == 'success'){
					successCallback(data.data)
				}else{
					alert(data.data.replyMsg);
				}
			}, function (data) {
				alert('Server not responding. <br/>Please try after sometime.');
			});
		},
        getData: function (urlPath, data, successCallback) {

           
			var ajaxRunning = $http({
				method: 'GET',
				url: siteUrl+'services/'+urlPath,
				data: data,
				dataType: "JSON",
				async: true,
			}).then(function (data) {
				if(data.data.replyCode == 'success'){
					successCallback(data.data)
				}else{
					//$ionMessage.ionAlert(data.data.replyMsg);
				}
			}, function (data) {
				//alert(data.data.replyMsg);
			});
        }
    }
}])