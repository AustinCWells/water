var mouse = {x: 0, y: 0};
var lastElement = null; 
var lastElementOutline = null;
var lastElementBackground = null; 
var lastPotentialElement = null; 
var notifyOnce = false; 
var frequency = "";
var notificationType = "";
var theDescription = ""; 
var theUserToken = "MHacksMagicJankUserToken";

console.log("send message");
chrome.runtime.sendMessage({greeting: "hello"}, function(response) {
  console.log("checking response");
});

function timeout() {
    setTimeout(function () {
        var first = $("#MagicJankMHacksID").prop('outerHTML');
        var second = lastElement;
        console.log("comparing " + first + " ___and__" + second);
        if(first === second) {
        	lastElement = first; 
        	timeout();
        } else {
        	alert("different");
        	// notify spence
        	if(!notifyOnce) {
        		lastElement = first; 
        		timeout();
        	}
        }
        
    }, 1000);
}

chrome.runtime.onMessage.addListener(
  function(request, sender, sendResponse) {
    console.log(sender.tab ?
                "from a content script:" + sender.tab.url :
                "from the extension");
    if (request.greeting == "hello"){
    	frequency = request.frequency;
    	notificationType = request.notificationType;
    	theDescription = request.descriptionType; 

    	console.log("frequency: " + frequency + "\nnotification type: " + notificationType + "\ndscription : " + theDescription);
    	 function unloadPage(){
           return null;
       }

		 window.onbeforeunload = unloadPage;

		$(document).click(false);

		$(document).click(function(e) {
			// notify server 
			$.get( "https://104.236.120.63/water/backend_code/", {
				userToken: theUserToken,
				description: theDescription,
				notificationMethod: notificationType,
				url: document.URL,
				recurrence:frequency
			}).done(function( data ) {
    			alert( "Data Loaded: " + data );
  			});

			$(document).unbind();
			e.preventDefault();
			e.stopPropagation();
			mouse.x = e.clientX || e.pageX; 
		    mouse.y = e.clientY || e.pageY;
		    var itemOfInterest = document.elementFromPoint(mouse.x, mouse.y);

		    // add a unique ID 
		    itemOfInterest.id = "MagicJankMHacksID";

		    // change background
		    itemOfInterest.style.background = "#30d600";
		    // every five second pull out item of interest
		    lastElement = $("#MagicJankMHacksID").prop('outerHTML');
		    timeout();
		    swal({  title: "Tracking New Item",   
		    		text: "You're tracking something on this page!",   
		    		type: "success",      
		    		confirmButtonText: "YAY I'M A CREEPER!",   
				}, function(){  window.open(document.URL); });

		   
		    
		});

		$(document).mouseover(function(e){
			mouse.x = e.clientX || e.pageX; 
		    mouse.y = e.clientY || e.pageY;
		    var itemOfPotentialInterest = document.elementFromPoint(mouse.x, mouse.y);
		    if(lastPotentialElement){
		    	lastPotentialElement.style.outline = "none";
		    }
		    lastPotentialElement = itemOfPotentialInterest; 
		    itemOfPotentialInterest.style.outline = "solid #30d600 4px";  

		})
    }
  });


