  function AGrilla(){        	
	  
		var app = angular.module('myapp_asientos', ['ui.bootstrap']);
		
		
		var ffecha1 = $("#ffecha1").val();
		var ffecha2 = $("#ffecha2").val();
		var festado = $("#festado").val();
		     
		alert(festado);
			
		app.filter('beginning_data', function() {
		    return function(input, begin) {
		        if (input) {
		            begin = +begin;
		            return input.slice(begin);
		        }
		        return [];
		    }
		});
		
		var url =  '../grilla/grilla_co_asientos.php?ffecha1='+ffecha1+'&ffecha2= ' + ffecha2 + '&festado=' + festado ;
		
		app.controller('controller', function($scope, $http, $timeout) {
			
		    $http.get(url).success(function(user_data) {
		        $scope.file = user_data;
		        $scope.current_grid = 1;
		        $scope.data_limit = 10;
		        $scope.filter_data = $scope.file.length;
		        $scope.entire_user = $scope.file.length;
		    });
		    $scope.page_position = function(page_number) {
		        $scope.current_grid = page_number;
		    };
		    $scope.filter = function() {
		        $timeout(function() {
		            $scope.filter_data = $scope.searched.length;
		        }, 20);
		    };
		    $scope.sort_with = function(base) {
		        $scope.base = base;
		        $scope.reverse = !$scope.reverse;
		    };
		});
		
  }	
		