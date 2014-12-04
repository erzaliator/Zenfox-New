/**
 * 
 */

function Inint_AJAX() {
   try {return new ActiveXObject("Msxml2.XMLHTTP");} catch(e) {} //IE
   try {return new ActiveXObject("Microsoft.XMLHTTP");} catch(e) {} //IE
   try {return new XMLHttpRequest();} catch(e) {} //Native Javascript
   alert("XMLHttpRequest not supported");
   return null;
};



function lookUp()
	{
	
	var line1 = document.getElementById('selectL1').value;
	var line2 = document.getElementById('selectL2').value;
	console.log(line1);
	console.log(line2);
	var lab1 = line1.split("/");
	var lab2 = line2.split("/");
	
	if(line1 == "" || line2 == "")
		{
			alert("please select both lines");
			return false;
		}
	
	//console.log(ar);
	$("#chartdiv").empty();
	$("#chartdiv").text("loading...");
	setCookie('line 1', line1);
	setCookie('line 2', line2);
	getIt(line1 , line2);
	//fetchData("/tracker/graph/format/json");
	
	}

function callGraph(line1 , line2)
		{ //alert("inside doc select function");
		 
		 var req = Inint_AJAX();
                 req.onreadystatechange = function () {
                                   if (req.readyState==4) {
                                   if (req.status==200)     {
	  								//alert(req.responseText);
									//alert(src);
                                	   							
                                                                document.getElementById("chartdiv").innerHTML="loading...";//req.responseText; //retuen value
                                                                //alert("in fetch");
                                                                $("#chartdiv").empty();
                                                                getIt(line1 , line2);
                                                                
                                                            }
                                                          }
                                                       };

		req.open("GET", "/tracker/uniquevisitors/format/json");
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=iso-8859-1"); // set Header
     req.send(null); //send value
		}