<?php
class Player_AdvertiseMentController extends Zend_Controller_Action
{
	public function init()
	{
		parent::init();
        $contextSwitch = Zend_Controller_Action_HelperBroker::getStaticHelper('ContextSwitch');
        $contextSwitch->addActionContext('getad', 'json')
    				->initContext();
	}
	public function getadAction()
	{
		$ad['url'] = 'http://zenfox.tld/images/fruit.jpg';
		$ad['type'] = 'image';
		$this->view->ad = $ad;
	}
}