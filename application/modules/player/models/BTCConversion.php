<?php
/**
 * This class is used to convert bitcoins to user currency amount
 */

class BTCConversion
{
	public function convertBTC($bitcoins, $toCurrency)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://bitcoincharts.com/t/weighted_prices.json');
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$file_contents = strstr(curl_exec($ch),'{'); // get everything starting from first curly bracket
		curl_close($ch);
		$bitCoinsValue = Zend_Json::decode($file_contents);
		
		$amount = $bitCoinsValue['USD']['24h'];
		$amount = $amount * $bitcoins;
		$fromCurrency = 'USD';
		
		$amount = urlencode($amount);
		$fromCurrency = urlencode($fromCurrency);
		$toCurrency = urlencode($toCurrency);
		
		$url = "http://www.google.com/finance/converter?a=$amount&from=$fromCurrency&to=$toCurrency";
		
		$ch = curl_init();
		$timeout = 0;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$rawdata = curl_exec($ch);
		curl_close($ch);
		$data = explode('bld>', $rawdata);
		$data = explode($toCurrency, $data[1]);
		return round($data[0], 2);
	}
}