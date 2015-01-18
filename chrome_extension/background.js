var mouse = {x: 0, y: 0};
var lastElement = null; 
var lastElementOutline = null;
var lastElementBackground = null; 
var lastPotentialElement = null; 
var notifyOnce = false; 
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
        	// noticfy spence
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
    	 function unloadPage(){
           return null;
       }

		 window.onbeforeunload = unloadPage;

		$(document).click(false);

		$(document).click(function(e) {
			$(document).unbind();
			e.preventDefault();
			e.stopPropagation();
			mouse.x = e.clientX || e.pageX; 
		    mouse.y = e.clientY || e.pageY;
		    var itemOfInterest = document.elementFromPoint(mouse.x, mouse.y);

		    // add a unique ID 
		    itemOfInterest.id = "MagicJankMHacksID";

		    // change background
		    itemOfInterest.style.background = "#5EC9B9";
		    // every five second pull out item of interest
		    lastElement = $("#MagicJankMHacksID").prop('outerHTML');
		    timeout();
		    
		});

		$(document).mouseover(function(e){
			mouse.x = e.clientX || e.pageX; 
		    mouse.y = e.clientY || e.pageY;
		    var itemOfPotentialInterest = document.elementFromPoint(mouse.x, mouse.y);
		    if(lastPotentialElement){
		    	lastPotentialElement.style.outline = "none";
		    }
		    lastPotentialElement = itemOfPotentialInterest; 
		    itemOfPotentialInterest.style.outline = "solid #5EC9B9 4px";  

		})
    }
  });


