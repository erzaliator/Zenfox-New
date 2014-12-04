function addJavascript(jsname,pos) {
var th = document.getElementsByTagName(pos)[0];
var s = document.createElement('script');
s.setAttribute('type','text/javascript');
s.setAttribute('src',jsname);
th.appendChild(s);
} 



//addJavascript('/js/jquery_tabs.js','head');

/*addJavascript('/js/jquery/js/custom.js','body');
addJavascript('/js/jquery_comments.js','body');
//addJavascript('/js/jquery.tools.min.js','body');
//addJavascript('/js/jquery.accordion.js','body');
addJavascript('/js/jquery.clockpick.js','body');
//addJavascript('/js/frontends/rum/front-banner.js','body');
addJavascript('/js/jquery/js/iepngfix_tilebg.js','body');
addJavascript('/js/jquery/js/jquery.pngFix.js','body');*/
//addJavascript('/js/jquery-ui-custom.min.js', 'body');

/*addJavascript('http://code.jquery.com/jquery-1.4.2.min.js','head');
addJavascript('/js/jquery_tabs.js','body');
addJavascript('/js/jquery_comments.js','body');
addJavascript('/js/jquery.tools.min.js','body');
addJavascript('/js/jquery.clockpick.js','body');
*/
