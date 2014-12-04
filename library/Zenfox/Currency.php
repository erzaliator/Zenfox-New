<?php
class Zenfox_Currency extends Zend_Currency
{
	public function setCurrency($currency, $value)
	{
		$currency = new Zend_Currency($currency);
		return $currency->toCurrency($value);
	}
}