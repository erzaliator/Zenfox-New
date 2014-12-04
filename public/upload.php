<?php 
$continue = true;
$start = 0;
$search = "aeron";
$results = 100;
$count = 0;
while($continue){
	$url = "https://www.google.co.in/search?q=" . $search . "&tbm=isch&start=" . $start . "&sa=N";
	$content = file_get_contents($url);
	
	preg_match_all('/<a href="\/url(.*?)<\/b>/', $content, $matches);
	
	foreach($matches[0] as $index => $value){
		if(strpos($value, "aeron")){
			preg_match_all('/src="https(.*?)"/', $value, $strmatches);
			foreach($strmatches[0] as $images){
				$allImages[] = substr($images, 4);
			}
		}
	}
	$start = $start + 20;
	if(count($allImages) >= 100){
		$continue = false;
	}
}
exit();


/* function sendElasticEmail($to, $subject, $body_text, $body_html, $from, $fromName)
{
	$res = "";

	$data = "username=".urlencode("admin@bingocrush.co.uk");
	$data .= "&api_key=".urlencode("d923f0eb-af00-4492-8619-aa0051a0b62b");
	$data .= "&from=".urlencode($from);
	$data .= "&from_name=".urlencode($fromName);
	$data .= "&to=".urlencode($to);
	$data .= "&subject=".urlencode($subject);
	if($body_html)
	$data .= "&body_html=".urlencode($body_html);
	if($body_text)
	$data .= "&body_text=".urlencode($body_text);

	$header = "POST /mailer/send HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
	$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

	if(!$fp)
	return "ERROR. Could not open connection";
	else {
		fputs ($fp, $header.$data);
		while (!feof($fp)) {
			$res .= fread ($fp, 1024);
		}
		fclose($fp);
	}
	return $res;
}
echo sendElasticEmail("nikhil@fortuity.in", "My Subject", "My Text", "My HTML", "admin@bingocrush.co.uk", "Your Name"); */

function get_remote_file_size($url) {

	$headers = get_headers($url, 1);
	
	print_r($headers);

	if (isset($headers['Content-Length']))
	return $headers['Content-Length'];

	//checks for lower case "L" in Content-length:
	if (isset($headers['Content-length']))
	return $headers['Content-length'];


}

echo get_remote_file_size('http://taashtime.tld/images/fruit.jpg');
?>