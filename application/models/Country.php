<?php

/**
 * Country
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class Country extends BaseCountry
{
	public function getAllCountriesList()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Country');
					
		$result = $query->fetchArray();
		//Zenfox_Debug::dump($result, 'data', true, true);
		return $result;
	}
	
	public function getCountryByCode($countryCode)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Country c')
					->where('c.country_code = ?', $countryCode);
		
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'e', true, true);
		}
		if($result)
		{
			return $result[0]['country'];
		}
		return NULL;
	}
}