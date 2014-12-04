<?php

$fromCurrency = $_POST['currency'];
$userAmount = $_POST['amount'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://bitcoincharts.com/t/weighted_prices.json');
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$file_contents = strstr(curl_exec($ch),'{'); // get everything starting from first curly bracket
curl_close($ch);
$bitCoinsValue = json_decode($file_contents, true);

$amount = $bitCoinsValue['USD']['24h'];
$toCurrency = 'USD';

$amount = urlencode($amount);
$fromCurrency = urlencode($fromCurrency);
$toCurrency = urlencode($toCurrency);

$url = "http://www.google.com/finance/converter?a=$userAmount&from=$fromCurrency&to=$toCurrency";

$ch = curl_init();
$timeout = 0;
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$rawdata = curl_exec($ch);
curl_close($ch);
$data = explode('bld>', $rawdata);
$data = explode($toCurrency, $data[1]);

$bitCoins = round($data[0], 2) / $amount; 
echo round($bitCoins, 2);