// JavaScript Document
function lIterator(listElement,delay)
  { /* Constructor */ 
    for(var i=listElement.childNodes.length-1; i>=0; i--) 
	    if(!/li/i.test(listElement.childNodes[i].nodeName))
		    listElement.removeChild(listElement.childNodes[i]);
			
			//Next step is to hide all the list items but first one
		for(var i=1; i<listElement.childNodes.length; i++)
	    listElement.childNodes[i].style.display = 'none';
		 //a dynamic property to the class that will store the pointer to the currently displayed list item:
		 this.currentLI = listElement.firstChild;
		 
		 /* Static Properties */
	lIterator.instances = new Array();
    this.id = lIterator.instances.length;
	lIterator.instances.push(this);
	setInterval('lIterator.instances['+this.id+'].showNext()',delay);
	/* Dynamic Methods */
	this.showNext = function()
	  { this.currentLI.style.display = 'none';
	    /* Following line is broken for readability */
		this.currentLI =
		    this.currentLI.nextSibling ?
                this.currentLI.nextSibling :
				this.currentLI.parentNode.firstChild;
        
		this.currentLI.style.display = 'block';
	  }
	  
	//86400000	 
  }
  

/*function rotateImage(idx) {
    var random = document.getElementById('banners');

    if (document.images) {
        random.style.background = 'url(' + pictures[idx] + ')';
        selectedImage = idx;
    }
}

function getNext() {
      var nextImage = selectedImage + 1;
      if (selectedImage >= numPics) {
          nextImage = 0;
      }
      rotateImage(nextImage);
}

function getPrev() {
      var prevImage = selectedImage - 1;
      if (selectedImage < 0) {
          selectedImage = numPics -1;
      }
      rotateImage(prevImage);
}

var pictures = new Array('images/icn_slide-1.jpg','images/icn_slide-2.jpg','images/icn_slide-1.jpg','images/icn_slide-2.jpg');
var numPics = pictures.length;
var selectedImage = null;

window.onload = function () {
     var chosenPic = Math.floor((Math.random() * numPics));
     rotateImage(chosenPic);
     document.getElementById('next').onclick = getNext;
     document.getElementById('prev').onclick = getPrev;
}
*/