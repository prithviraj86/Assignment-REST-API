var shopApp = angular.module('shopapp',[]);  

shopApp.controller('maincontroller', function ($scope,$http) {
 
$scope.shop = {};
$scope.save_shop = function() {
	
	//alert($scope.shop.name);
	
	 $http.post('http://localhost:8000/api/shop', 
            {
                'name'     : $scope.shop.name
            }
        ) .success(function (data, status, headers, config) {
			
          if(data=='save')
			{
				alert(data)
			}
			else if(data=='error')
			{
				alert("some thing wrong on the page");
			}
			else
			{
				
				alert(data);
			}
          //$scope.get_product();
        //location.reload();

        })

        .error(function(data, status, headers, config){
           alert("Fail to create database");
        });
	
       
       
    }

    

});
