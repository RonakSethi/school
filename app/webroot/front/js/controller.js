 angular.module('fundraiser.controllers', ['infinite-scroll'])
 .controller('loginController', function($scope, $rootScope, $location, $routeParams,$ajax) {
	$scope.rec = {}
	$scope.rec.IsVisibleError = false
	$scope.getAllList = function(){
		$ajax.postData('get_distributor_code', {'keyword':$scope.rec.keyword},function(data){
			$scope.rec.IsVisible = true;
			$scope.rec.suggestions = data.data;
		});
	}	
	
	$scope.getCode = function(val){
		$scope.rec.keyword = val;
		$scope.rec.IsVisible = false;
		
	}
	
	$scope.submit = function(){
		var val = $scope.rec.keyword
		if (val) {
			$scope.rec.IsVisibleError = false
			$ajax.postData('check_distributor_code', {'code':$scope.rec.keyword},function(data){		
				localStorage.setItem('User.code', $scope.rec.keyword);
				localStorage.setItem('User.distributor_id', data.data.User.id);
				localStorage.setItem('User.fundraiser_id', data.data.User.parent_id);
				$location.path('/product_list');
			});
		}else{
			$scope.rec.IsVisibleError = true
			$scope.rec.error = 'Distributor code is required';
		}
	}
	
})
.controller('productListController', function($scope, $rootScope, $location, $routeParams,$ajax) {
	$scope.product = {}
	var page = 2;
	var busy = false;
	var limit = 20;
	var storageCode = localStorage.getItem('User.code');
	var storageDistributorId = localStorage.getItem('User.distributor_id');
	var storageFundraiserId = localStorage.getItem('User.fundraiser_id');
	$scope.product.header_vis = true;
	$scope.product.cartCount = (localStorage.getItem('Cart.'+storageDistributorId+'')) ? Object.keys( JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')) ).length : '0';
		$ajax.postData('get_project_list/page:1', {'distributor_id':storageDistributorId,'fundraiser_id':storageFundraiserId,'code':storageCode},function(data){
		if(data.data != ''){
				$scope.product.list = data.data.Product;
				$scope.product.header = data.data.FundRaiser.header;
				$scope.product.logo = data.data.FundRaiser.logo;
				$scope.product.totalPage = data.totalPage;
				$scope.product.count = data.data.count;
			}else{
				$scope.product.header_vis = false;
				$scope.product.no_record = true;
				$scope.product.count = 0
			}
		});
		
		$scope.switchShop = function(){
			$location.path('/login');
		}
		
		$scope.loadMore = function() {
			if(!busy && $scope.product.count == limit){
				busy = true;
				$ajax.postData('get_project_list/page:'+page, {'distributor_id':storageDistributorId,'fundraiser_id':storageFundraiserId,'code':storageCode},function(data){
					var dataCount = data.data.count
					if($scope.product.totalPage == page){
						busy = true;
						for(var i = 0; i <= dataCount-1; i++) {
							$scope.product.list.push(data.data.Product[i]);
						}
					}else{
						for(var i = 0; i <= dataCount-1; i++) {
							$scope.product.list.push(data.data.Product[i]);
						}
						busy = false;
						page++;
						
					}
				});
			}
			
		}
		
		$scope.product_detail = function(product_id){
			$location.path('/product_detail/'+product_id);
		}
		
		$scope.cart = function(){
			$location.path('/cart');
		}
		
})
.controller('productDetailController', function($scope, $rootScope, $location, $routeParams,$ajax) {
	$scope.productDetail = {}
	var storageCode = localStorage.getItem('User.code');
	var storageDistributorId = localStorage.getItem('User.distributor_id');
	var storageFundraiserId = localStorage.getItem('User.fundraiser_id');
	var quantity = 1;
	var product_store = []
	$scope.productDetail.cartBtn = true
	$scope.productDetail.QuntityCont = true
	$scope.productDetail.cartCount = (localStorage.getItem('Cart.'+storageDistributorId+'')) ? Object.keys( JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')) ).length : '0';
	if(localStorage.getItem('Cart.'+storageDistributorId+'')){
		angular.forEach(JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')), function(value, key){
			  if(value.id == $routeParams.product_id){
				$scope.productDetail.cartBtn = false
				$scope.productDetail.QuntityCont = false
			  }
		});
	}
	
	
	$ajax.postData('get_product_detail', {'product_id':$routeParams.product_id},function(data){
	if(data.data != ''){
			$scope.productDetail.quantityVal = quantity; 
			$scope.productDetail.image = data.data.Product.picture
			$scope.productDetail.name = data.data.Product.name
			$scope.productDetail.cost = data.data.Product.cost
			$scope.productDetail.description = data.data.Product.description
			$scope.productDetail.minimum_qty = data.data.Product.minimum_qty
			$scope.productDetail.product = data.data.Product;
			$scope.productDetail.id = data.data.Product.id;
		}
	}); 
	
	$scope.productQuantity = function(type){
		if(type == 'p'){
			if(quantity < $scope.productDetail.minimum_qty){
				quantity++
			}
		}else{
			if(quantity > 1){
				quantity--
			}
		}
		
		$scope.productDetail.quantityVal = quantity; 
	}
	
	$scope.addToCart = function(){
		$scope.saved = localStorage.getItem('Cart.'+storageDistributorId+'');
		product_store = (localStorage.getItem('Cart.'+storageDistributorId+'')) ? JSON.parse($scope.saved) : [];
		$scope.productDetail.product.quantity = quantity
		product_store.push($scope.productDetail.product)
		localStorage.setItem('Cart.'+storageDistributorId+'', JSON.stringify(product_store));
		$scope.productDetail.cartBtn = false
		$scope.productDetail.QuntityCont = false
		$scope.productDetail.cartCount = Object.keys( JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')) ).length
		console.log(localStorage.getItem('Cart.'+storageDistributorId+''));
			
	}
	
	$scope.cart = function(){
			$location.path('/cart');
		}
	
})
.controller('cartController', function($scope, $rootScope, $location, $routeParams,$ajax) {
	$scope.cart = {}
	var storageCode = localStorage.getItem('User.code');
	var storageDistributorId = localStorage.getItem('User.distributor_id');
	var storageFundraiserId = localStorage.getItem('User.fundraiser_id');
	$scope.cart.noRecord = false;
	$scope.cart.total = true;
	$scope.cart.total_product = 0
	$scope.cart.list = JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+''));
	if(localStorage.getItem('Cart.'+storageDistributorId+'') && Object.keys( JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')) ).length >= 1){
		angular.forEach(JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')), function(value, key){
			  $scope.cart.total_product += Number(value.cost*value.quantity)
		});
	}else{
		$scope.cart.total = false;
		$scope.cart.noRecord = true	
	}
	
	$scope.increaseQuantity = function(qEl){
		if(qEl.quantity != qEl.minimum_qty){
			var product_quantity_add = []
			$scope.cart.total_product = 0
			angular.forEach(JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')), function(value, key){
				  if(qEl.id == value.id){
					value.quantity = Number(qEl.quantity+1);
				  }
				  $scope.cart.total_product += Number(value.cost*value.quantity)
					product_quantity_add.push(value)
			});
			localStorage.setItem('Cart.'+storageDistributorId+'', JSON.stringify(product_quantity_add));
			$scope.cart.list = JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+''));
		}
	}
	
	
	$scope.decreaseQuantity = function(qEl){
		if(qEl.quantity > 1){
			var product_quantity_remove = []
			$scope.cart.total_product = 0
			angular.forEach(JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')), function(value, key){
				  if(qEl.id == value.id){
					value.quantity = Number(qEl.quantity-1)
				  }
				  $scope.cart.total_product += Number(value.cost*value.quantity)
				  product_quantity_remove.push(value)
			});
			console.log(product_quantity_remove);
			localStorage.setItem('Cart.'+storageDistributorId+'', JSON.stringify(product_quantity_remove));
			$scope.cart.list = JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+''));
		}
	}
	
	$scope.deleteCartProduct = function(el){
		if(localStorage.getItem('Cart.'+storageDistributorId+'')){
		$scope.cart.total_product = 0
		var product_remove = []
		angular.forEach(JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')), function(value, key){
			  if(value.id != el.id){
				 product_remove.push(value)
				 $scope.cart.total_product += Number(value.cost*value.quantity)
			  }
		});
			
			localStorage.setItem('Cart.'+storageDistributorId+'', JSON.stringify(product_remove))
			
			var myEl = angular.element( document.querySelector( '#cartCont'+el.id ) );
			myEl.remove();
			
			if(Object.keys( JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')) ).length == 0){
				$scope.cart.noRecord = true;
			}
		}
	}
	
	$scope.checkout = function(){
		$location.path('/checkout');
	}
	
})
.controller('checkoutController', function($scope, $rootScope, $location, $routeParams,$ajax) {
	$scope.checkout = {}
	var storageCode = localStorage.getItem('User.code');
	var storageDistributorId = localStorage.getItem('User.distributor_id');
	var storageFundraiserId = localStorage.getItem('User.fundraiser_id');
	$scope.checkout.total_price = 0
	if(localStorage.getItem('Cart.'+storageDistributorId+'') && Object.keys( JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')) ).length >= 1){
			angular.forEach(JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')), function(value, key){
				$scope.checkout.total_price += Number(value.cost*value.quantity)
			});
	}else{
		$location.path('/product_list');
	}
	$ajax.postData('get_country_list/', {},function(data){
		$scope.checkout.country_list = data.data
	})
	
	$scope.stripeCallback = function (code, result) {
		if (result.error) {
			window.alert('All fields are required');
		} else {
			var storageDistributorId = localStorage.getItem('User.distributor_id');
			var storageFundraiserId = localStorage.getItem('User.fundraiser_id');
			var formData =  {address: $scope.checkout.address, city: $scope.checkout.city, country:$scope.checkout.country, email:$scope.checkout.email, full_name:$scope.checkout.full_name, phone:$scope.checkout.phone, state:$scope.checkout.state, total_price:$scope.checkout.total_price, zip_code:$scope.checkout.zip_code, card_num:$scope.number, expiry:$scope.expiry, cvc:$scope.cvc, cardName:$scope.cardName, is_same_address:$scope.is_same_address, fundraiser_id:storageFundraiserId, distributor_id:storageDistributorId} 
			console.log(JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')));
			
			$ajax.postData('checkout', {'token':result.id,'cartData':JSON.parse(localStorage.getItem('Cart.'+storageDistributorId+'')), 'Data':formData},function(data){
				localStorage.removeItem('Cart.'+storageDistributorId+'');
				$location.path('/success');
			}); 
			//window.alert('success! token: ' + result.id);
		}
	}
	
	
})
.controller('successController', function($scope, $rootScope, $location, $routeParams,$ajax) {
	$scope.success = {}
	
	$scope.backToProduct = function(){
		$location.path('/product_list');
	};
})
