<?php
class Player_AffiliateController extends Zenfox_Controller_Action
{
	public function programAction()
	{
		$this->view->advertisingSiteName = Zend_Registry::isRegistered('advertisingSiteName')?Zend_Registry::get('advertisingSiteName'):"<Advertising Site>";
	}
}