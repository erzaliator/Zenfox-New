<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Untitled Document</title>
<link rel="stylesheet" href="/css/rummybazaar/sai.css" type="text/css" />
<link rel="stylesheet" href="/css/rummybazaar/tj.css" type="text/css" />
<link rel="stylesheet" href="/css/rummybazaar/jquery.bxslider.css" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/css/rummybazaar/mobile.css">
<link rel="stylesheet" href="/css/rummybazaar/tab-port.css">
<link rel="stylesheet" href="/css/rummybazaar/tab-land.css">
<link rel="stylesheet" href="/css/rummybazaar/colorbox.css">

<script type="text/javascript" src="/js/rummybazaar/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/js/rummybazaar/jquery.bxslider.js"></script>
<script type="text/javascript" src="/js/rummybazaar/custom.js"></script>
<script type="text/javascript" src="/js/rummybazaar/jquery.colorbox.js"></script>
<script type="text/javascript" src="/js/rummybazaar/error.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
function openGame(url, width, height) {
	var leftPosition, topPosition;
	//Allow for borders.
	leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
	//Allow for title and status bars.
	topPosition = (window.screen.height / 2) - ((height / 2) + 50);
	//Open the window.
	window.open(url, "game","status=no,height=" + height + ",width=" + width + ",resizable=yes,left="
	+ leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY="
	+ topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
}
</script>

</head>