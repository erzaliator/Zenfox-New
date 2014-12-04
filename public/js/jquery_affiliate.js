function addJavascript(jsname,pos) {
	var th = document.getElementsByTagName(pos)[0];
	var s = document.createElement('script');
	s.setAttribute('type','text/javascript');
	s.setAttribute('src',jsname);
	th.appendChild(s);
	} 

	//addJavascript('http://code.jquery.com/jquery.min.js','head');
	addJavascript('/js/jquery.clockpick.js','body');