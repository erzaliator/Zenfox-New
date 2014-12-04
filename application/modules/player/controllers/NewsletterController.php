<?php

class Player_NewsletterController extends Zend_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function subscribeAction()
    {
    	if(isset($_POST['nlEmail']) && $_POST['nlEmail'])
    	{
    		$email = $_POST['nlEmail'];
    		
    		$newletter = new Newsletter();
    		echo $newletter->addNewEmail($email);
    	}
    	else
    	{
    		echo "Please enter an email";
    	}
    }
}