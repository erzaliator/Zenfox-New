<?php

/**
 * Currency
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class Currency extends BaseCurrency
{
	public function getCurrenies()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Currency');
					
		$result = $query->fetchArray();
		
		return $result;
	}
	
	public function getCurrencybyCode($currencyCode)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Currency')
					->where('currency_code = ?' , $currencyCode);
					
		$result = $query->fetchArray();
		
		$currency = array();
		
			$currency["currencyCode"] = $result[0]["currency_code"];
			$currency["currencyDescription"] = $result[0]["currency_description"];
			$currency["currency"] = $result[0]["currency"];
			$currency["symbol"] = $result[0]["symbol"];
			
		
		
		return $currency;
	}
}