
window.onload = gamification;

function gamification() {
	
  setInterval("checkmessages();", 10000); // milliseconds
}

function checkmessages() {
	
   $.ajax(
			{ 
			url:"http://testserver.tld/server.phtml",
			 dataType: "text",
			 type: "GET",
			 success:function(value)
				{
				 var result = $.parseJSON(value);
				 var url = result.result["message"];
						
						  ifrm = document.createElement("IFRAME"); 
						   ifrm.setAttribute("src", url); 
						   ifrm.style.width = 640+"px"; 
						   ifrm.style.height = 480+"px"; 
						   document.getElementById("testing").innerHTML = "";
						   document.getElementById("testing").appendChild(ifrm); 				
  				},
  				error:function(value)
  				{
  					alert("FAILED");
  				}
		}
		);
}

