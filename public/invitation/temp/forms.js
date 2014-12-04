

window.onload = getforms;
var _formid;
function getforms()
{

		    var notifications = new $.ttwNotificationCenter({
	        bubble:{
	            useColors:true
	        },
	        
	        serverSideSave:false,
	        serverSideGet:false,
	        serverSideGetNew:false,
	        serverSideDelete:false
	    });

	    notifications.initMenu({
	        projects:'#projects',
	        tasks:'#tasks',
	        messages:'#messages'
	    });
   
	    setInterval(function(){
	    	callWebServer();
	    }, 30000
	    );
	    
	    callWebServer = function()
	    {
	    	 $.ajax(
	    				{ 
	    				url:"http://testserver.tld/server.phtml",
	    				 dataType: "text",
	    				 type: "GET",
	    				 success:function(value)
	    					{
	    					 	
	    					 var result = $.parseJSON(value);
	    					 
	    					 /*
	    					  * TODO: Display 'message' (form) only after the iframe is loaded.
	    					  */
	    					// alert(result.result["message"]);
	    						var url = result.result["message"];
	    							   result.result["message"] = '<iframe id=\"message\" name=\"message\" src='+ url+' onload=\"hidebutton()\" width=\"600\" height=\"200\" align=\"bottom\" frameborder=\"0\ ">';
	    							   result.result["url"] = url;
    							    notifications.createNotification(result.result, 1);
	    	  				},
	    	  				error:function(value)
	    	  				{
	    	  					alert("FAILED");
	    	  				}
	    			}
	    			);
	   
	    	
	    }
	    
	   
};
function hidebutton()
{
	theForms = document.getElementById('message').contentWindow.document.getElementsByTagName("form");
	_formid = document.getElementById('message').contentWindow.document.getElementById(theForms[0].id);
	_formid.target = "_blank";
	//_formid.onsubmit = function(event){ event.preventDefault(); manualsubmit()};
}

function manualsubmit()
{
	var length = _formid.elements[0].length;
	var i=0;
	var ajaxdata ='{ ';
	
	var length = _formid.elements.length;
	for(i=0; i<(length-1); i++)
	{
	   var fieldName = _formid.elements[i].name;
	   var fieldValue = _formid.elements[i].value;

	   if(i==0)
		   {
		   ajaxdata += '"'+fieldName+'"'+':'+'"'+fieldValue+'"';
		   }
	   else
		   {
		   ajaxdata += ',' +'"'+fieldName+'"'+':'+'"'+fieldValue+'"';
		   }
	   
	}
	ajaxdata += " }"; 
		var action = _formid.action;
		var datainjson = new Object();
		
		
		var datainjson = JSON.parse(ajaxdata);
		
		 $.ajax(
 				{ 
 				url:action,
 				datatype:"JSON",
 				 type: "POST",
 				data:datainjson,
 				 success:function(value)
 					{
 					 	alert("success");
 					 	//openpage();
 	  				},
 	  				error:function(value)
 	  				{
 	  					alert("FAILED");
 	  				}
 			}
 			);
	
}



function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}