angular.module('fundraiser.routes', ['ngRoute','angularPayments'])
.config(function($routeProvider) {
		Stripe.setPublishableKey('pk_test_1JmCbGVhc4DxD39ajqXcncBN')
		//window.Stripe.setPublishableKey('pk_test_1JmCbGVhc4DxD39ajqXcncBN');		
      $routeProvider
        .when('/login', {
          controller:'loginController',
          templateUrl:'front/view/home.html',
        }).when('/product_list', {
          controller:'productListController',
          templateUrl:'front/view/product_list.html',
        })
		.when('/product_detail/:product_id', {
          controller:'productDetailController',
          templateUrl:'front/view/product_detail.html',
        })
		.when('/cart', {
          controller:'cartController',
          templateUrl:'front/view/cart.html',
        })
		.when('/checkout', {
          controller:'checkoutController',
          templateUrl:'front/view/checkout.html',
        })
		.when('/success', {
          controller:'successController',
          templateUrl:'front/view/confirmation.html',
        })
        .otherwise({
          redirectTo:'/login'
        });
})