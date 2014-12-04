/**
 * 
 */

//console.log(getCookie('L1'));
if(getCookie('L1') != null) sendDataL1();
if(getCookie('L2') != null) sendDataL2();
if(getCookie('line 1') != null && getCookie('line 2') != null) getIt(getCookie('line 1'), getCookie('line 2'));
	

function setCookie(name, value, expires, path, domain, secure) {
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}


function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}




var trackNo = $("#trackNo").val();
var id;

function relod(par)
{
	var trackNo = $("#trackNo").val();
	$('#trackerTab').empty();
	var x= trackNo;
	if(par == 5)
	{	
		$('#viewMore').empty();
		$('#trackerTab').load('/tracker/view/ #trackerTab',{'val':x});
	//	$('#viewMore').empty();
		//$('#viewMore').html('view recent');
	}
	
	if(par == trackNo)
	{
		$('#viewMore').empty();
		$('#trackerTab').load('/tracker/view/ #trackerTab',{'val':''});
	//	$('#viewMore').empty();
		//$('#viewMore').html('view more');
	}
			
}



function sendDataL1()
{
	setCookie('L1', 'sendDataL1()');
	$("#selectL1").empty();
	//$("#selectL2").empty();
	var track0 = $("#track1").val();
	var track1 = $("#track2").val();
	var k = 0;
	var radVal = $("input:radio[name=rad]:checked").val();
	
	
	
	if(track0 == "")
		{
			console.log("TRACK 0 is empty");
			selectBuild(radVal , 'track0')
		}
	
	if(track0 != "")
	{
				console.log("track0 != ''");
		
				
				
				
				$("#selectL1").append("<option value='' >Tracker-"+track0+" line</option>"+
									   "<option value='/tracker/uniquevisitors/trackId/"+track0+"''>Unique visitors</option>"+
									   "<option value='/tracker/visitors/trackId/"+track0+"''>Visitors</option>");
				
										   
			}
	

}


function sendDataL2()
{
	setCookie('L2', 'sendDataL2()');
	//$("#selectL1").empty();
	$("#selectL2").empty();
	var track0 = $("#track1").val();
	var track1 = $("#track2").val();
	var k = 0;
	var radVal = $("input:radio[name=rad]:checked").val();
	//console.log(track0);
	
	
	if(track1 == "")
		{
			console.log(track1);
			selectBuild(radVal , 'track1')
		}
	
		if(track1 != "")
		{
				console.log(track1);
			
				$("#selectL2").append("<option value='' >Tracker-"+track1+" line</option>"+
									   "<option value='/tracker/uniquevisitors/trackId/"+track1+"' >Unique visitors</option>"+
									   "<option value='/tracker/visitors/trackId/"+track1+"'>Visitors</option>");
									   
		
		}


}

function sendDataEarning()
{
	$("#selectL1").empty();
	$("#selectL2").empty();
	var track0 = $("#track1").val();
	var track1 = $("#track2").val();
	
	var k = 0;

	for(var i=0; i<2; i++)
	{
		k = k+1;
		var track = 'track'+i;
		console.log(track);
		
	
		if(i==0)
				$("#selectL"+k).append("<option value='' >Tracker-"+track0+" line</option>"+
									   "<option value=''>Earnings</option>"+
									   "<option value=''>Deposits</option>");
		if(i==1)
				$("#selectL"+k).append("<option value='' >Tracker-"+track1+" line</option>"+
										   "<option value='' >Earnings</option>"+
										   "<option value=''>Deposits</option>");
	}


}


function build(track1,val) 
{
	console.log(track1);
	console.log(val);
	
	$("#selectL2").empty();
	if(val==2)
	$("#selectL2").append(
						   "<option value='3'>Earnings</option>"+
						   "<option value='3'>Deposite</option>");
	if(val == 1)
	$("#selectL2").append(
							"<option value='/tracker/uniquevisitors/trackId/"+track1+"' >Unique visitors</option>"+
							"<option value='/tracker/visitors/trackId/"+track1+"'>Visitors</option>");
	
}

function graphType()
{
	//var type = $("#rad").val();
	var track0 = $("#track1").val();
	var track1 = $("#track2").val();
	
	var val = $("input:radio[name=rad]:checked").val();
	console.log(val);
	if (track0 == "" && track1 == "" && val == 'visits')
		{
			selectBuild(val);
									   
		}
	
	if (track0 == "" && track1 == "" && val == 'earnings')
		{
			selectBuild(val);
								   
		}
	 
		 
	if (track0 == "" && track1 != "")
		{
			alert("Select other tracker");
			$("#selectL1").empty();
			$("#selectL2").empty();
			return false;
		}
	
	if (track0 != "" && track1 == "")
		{
			alert("Select other tracker");
			$("#selectL1").empty();
			$("#selectL2").empty();
			
			return false;
		}
	
	if (track0 != "" && track1 != "" && val == 'visits')
	{
		sendDataL1();
		sendDataL2();
	}
	
	if (track0 != "" && track1 != "" && val == 'earnings')
	{
		sendDataEarning();
	}
	
}


function selectBuild(type , track)
{
	if(type == 'visits' && track == 'track0')
		{
			console.log("type == 'visits' && track == 'track0'");
			$("#selectL1").empty();
			
		//	$("#selectL2").empty();
	
	
	
	
			$("#selectL1").append("<option value='' > line</option>"+
								   "<option value='/tracker/uniquevisitors'>Unique visitors</option>"+
								   "<option value='/tracker/visitors'>Visitors</option>");
			
		//	$("#selectL2").append("<option value='' >line</option>"+
		//							   "<option value='/tracker/uniquevisitors' >Unique visitors</option>"+
		//							   "<option value='/tracker/visitors'>Visitors</option>");
		}
	
	
	if(type == 'visits' && track == 'track1')
	{
		console.log("type == 'visits' && track == 'track1'");
	//	$("#selectL1").empty();
		$("#selectL2").empty();




	//	$("#selectL1").append("<option value='' > line</option>"+
	//						   "<option value='/tracker/uniquevisitors'>Unique visitors</option>"+
	//						   "<option value='/tracker/visitors'>Visitors</option>");
		
		$("#selectL2").append("<option value='' >line</option>"+
								   "<option value='/tracker/uniquevisitors' >Unique visitors</option>"+
								   "<option value='/tracker/visitors'>Visitors</option>");
	//	$("#selectL2").empty();
	//	console.log("$('#selectL2').empty()");
	}

	
	
	if(type == 'earnings')
		{
		console.log("track0 == null && track1 == null && type == 'earnings'");
		$("#selectL1").empty();
		$("#selectL2").empty();
	
	
	

		$("#selectL1").append("<option value='' > line</option>"+
							   "<option value=''>Earnings</option>"+
							   "<option value=''>Deposites</option>");
		
		$("#selectL2").append("<option value='' >line</option>"+
								   "<option value='' >Earnings</option>"+
								   "<option value=''>Deposites</option>");
		}
	
}