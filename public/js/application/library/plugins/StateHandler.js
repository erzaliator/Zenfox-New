
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

function Delete_Cookie( name, path, domain ) {
if ( getCookie( name ) ) document.cookie = name + "=" +
( ( path ) ? ";path=" + path : "") +
( ( domain ) ? ";domain=" + domain : "" ) +
";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

function remakeCookie(tabName)
{
	var cxtypeStr = getCookie('tab');
	var newStr = '';
	tabArr = [];
	newTabArr = [];
	tabArr = cxtypeStr.split('+');
	
	for(var i=0 ; i<tabArr.length; i++)
	{
		if(tabArr[i] != tabName)
		{
			newTabArr.push(tabArr[i]);
		}
	}
	
	for(var j=0 ; j<newTabArr.length; j++)
	{
		if(j == 0)
			newStr = newTabArr[j];
		else
			newStr = newStr+'+'+newTabArr[j];
	}
	
	Delete_Cookie('tab');
	setCookie('tab', newStr);
		
}