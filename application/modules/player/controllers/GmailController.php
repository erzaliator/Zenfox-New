<?php
require_once dirname(__FILE__).'/../forms/GmailLoginForm.php';
class Player_GmailController extends Zenfox_Controller_Action
{
	public function inviteAction()
	{
		//Zend_Layout::getMvcInstance()->disableLayout();
		$user = $_POST['gmailLogin'];
		$pass = $_POST['gmailPassword'];
	   	//$pass = "alwaysb+!(*%";
	    // perform login and set protocol version to 3.0
	    $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, 'cp');
	    $gdata = new Zend_Gdata($client);
	    $gdata->setMajorProtocolVersion(3);
		//perform query and get result feed
	    $query = new Zend_Gdata_Query('http://www.google.com/m8/feeds/contacts/default/full');
	    $feed = $gdata->getFeed($query);
		//echo $feed->totalResults;
		$results = array();
      	foreach($feed as $entry)
      	{
	        $xml = simplexml_load_string($entry->getXML());
	        $obj = new stdClass;
	        $obj->name = (string) $entry->title;
	        $obj->orgName = (string) $xml->organization->orgName; 
	        $obj->orgTitle = (string) $xml->organization->orgTitle; 
	
	        foreach ($xml->email as $e)
	        {
	       		$obj->emailAddress[] = (string) $e['address'];
	        }
	        foreach ($xml->phoneNumber as $p)
	        {
	        	$obj->phoneNumber[] = (string) $p;
	        }
	        foreach ($xml->website as $w)
	        {
	        	$obj->website[] = (string) $w['href'];
	        }
	
	        $results[] = $obj;
      	}
      	$emailAddresses = array();
      	foreach ($results as $r)
      	{
      		$emailAddresses[] = @join(', ', $r->emailAddress);
      	}
      	//Zenfox_Debug::dump($emailAddresses, 'emails');
      	$form = new Player_GmailLoginForm();
		$this->view->form = $form->friendsList($emailAddresses);
	}
}