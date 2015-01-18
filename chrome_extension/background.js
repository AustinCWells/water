var mouse = {x: 0, y: 0};
var lastElement = null; 
var lastElementOutline = null;
var lastElementBackground = null; 
var lastPotentialElement = null; 

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
			e.preventDefault();
			e.stopPropagation();
			mouse.x = e.clientX || e.pageX; 
		    mouse.y = e.clientY || e.pageY;
		    var itemOfInterest = document.elementFromPoint(mouse.x, mouse.y);
		    if(lastElement){
		    	lastElement.style.outline = "none";
		    	lastElement.style.background = lastElementBackground;
		    }
		    lastElement = itemOfInterest; 
		    lastElementOutline = itemOfInterest.style.outline;
		    itemOfInterest.style.outline = "solid #5EC9B9 4px";
		    lastElementBackground = itemOfInterest.style.background; 
		    itemOfInterest.style.background = "#5EC9B9";

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


