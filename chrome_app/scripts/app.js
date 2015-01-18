(function(){
var app = angular.module('myapp', []); 
var token = "MHacksMagicJankUserToken";
app.controller('NotificationsController', ['$http', '$scope', function($http, $scope){

	// get items in list
	function updateList() {
    setTimeout(function () {
        	$http.get('https://104.236.120.63/water/backend_code?userToken=MHacksMagicJankUserToken').
		  		success(function(data, status, headers, config) {
		  		console.log(data);
		    	notificationCenter.notification = data;
		    	for (var key in data) {
		    		console.log("alert?: " + data[key].alert);
		    		if(data[key].alert) {
		    			var notification = new Notification("something has changed!\n" + data[key].description);
		    			$http.get('https://104.236.120.63/water/backend_code?itemNum=' + key + '&success=true').
		  				success(function(data, status, headers, config) {
		  					console.log("notifiesUser");
		  				});
		    		}

		    	}
	 		 }).
			  error(function(data, status, headers, config) {
			  	console.log("error")
			    // called asynchronously if an error occurs
			    // or server returns response with an error status.
			  });
			  updateList();
        }, 1000)
	};

    updateList();

    function checkNotification() {
    setTimeout(function () {
        
        }, 1000)
	};

	var notificationCenter = this; 
	$scope.job;
	$scope.myFunction = function(key){
		delete notificationCenter.notification[key];
		$scope.shouldDisplay = "hideIt";
		console.log("key: " + key);
		$http.get('https://104.236.120.63/water/backend_code?itemNum=' + key).
  		success(function(data, status, headers, config) { }).
	  error(function(data, status, headers, config) {
	  	console.log("error")
	  });
	};


	
}]);


})();


// var notification = {
//     "54bb7964a203cd750e7b23c8": {
//         "_id": {
//             "$id": "54bb7964a203cd750e7b23c8"
//         },
//         "alert": "true",
//         "description": "Track google search input box thingy.",
//         "notificationMethod": "CHROMENOTIFICATION",
//         "recurrence": "once",
//         "url": "https://www.google.com/?gws_rd=ssl",
//         "userToken": "MHacksMagicJankUserToken"
//     },
//     "54bb7c3aa203cdd50d7b23c7": {
//         "_id": {
//             "$id": "54bb7c3aa203cdd50d7b23c7"
//         },
//         "alert": "true",
//         "description": "we the people atth we hiwt ihwet hwiethiwethiehrvevrihervih ",
//         "notificationMethod": "EMAIL",
//         "recurrence": "once",
//         "url": "https://www.google.com/?gws_rd=ssl",
//         "userToken": "MHacksMagicJankUserToken"
//     },
//     "54bb7cd4a203cdec0d7b23c9": {
//         "_id": {
//             "$id": "54bb7cd4a203cdec0d7b23c9"
//         },
//         "userToken": "MHacksMagicJankUserToken",
//         "description": "Cowboys game",
//         "notificationMethod": "CHROMENOTIFICATION",
//         "url": "https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=dallas%20cowboys",
//         "recurrence": "recurring",
//         "alert": false
//     },
//     "54bb7d65a203cdd40d7b23c8": {
//         "_id": {
//             "$id": "54bb7d65a203cdd40d7b23c8"
//         },
//         "userToken": "MHacksMagicJankUserToken",
//         "description": "When the temperature changes ",
//         "notificationMethod": "TEXT",
//         "url": "https://www.google.com/search?q=temperature&oq=temperature&aqs=chrome..69i57j69i60l5.2758j0j9&sourceid=chrome&es_sm=91&ie=UTF-8",
//         "recurrence": "recurring",
//         "alert": false
//     }
// };