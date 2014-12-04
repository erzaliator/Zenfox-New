<?php
class Locale
{
	public function setLocale($locale)
	{
		$zl = new Zend_Locale();
        $zl->setLocale($locale);
        if($zl == 'root')
        {
        	$session = new Zend_Session_Namespace('language');
    		$session->unsetAll();
        	$locale = Zend_Registry::get('Zend_Locale');
        }
        
        return $locale;
	}
}