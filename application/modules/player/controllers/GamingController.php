<?php
//require_once ('Rabbitmq/AMQPConnection.php');
require_once dirname(__FILE__).'/../forms/AddUrlForm.php';
class Player_GamingController extends Zenfox_Controller_Action
{
	public function init()
	{
		//Zend_Layout::getMvcInstance()->disableLayout();
		parent::init();
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('index', 'json')
              	->initContext();
	}
	
	public function indexAction()
	{
		$options['host'] = '192.168.1.15';
		$options['port'] = 5672;
		$options['user'] = 'guest';
		$options['pass'] = 'guest';
		$options['vhost'] = '/';
		
		 $r = new Rabbit($options);

        $this->view->form = $form = new Player_AddUrlForm();
        // process form
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getParams();
            if ($form->isValid($formData)) {
                $r->setUrl($form->url->getValue());
                $r->run();
            } else {
                $form->populate($formData);
            }
        }

        $r->setUrl("http://www.seznam.cz");
        $r->run();
        $this->view->url = $r->getUrl();
		echo "in gaming";
		/* $frontendId = Zend_Registry::getInstance()->get('frontendId');
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
//		Zenfox_Debug::dump($store, 'sessionData',true);
		
		$playerId = $store['id'];
		if(!$playerId)
		{
			$this->_helper->FlashMessenger(array('error' => 'No record found.'));
		}
		$login = $store['authDetails'][0]['login'];
		$password = $store['authDetails'][0]['password'];
		
		$gameGroupFrontend = new GamegroupFrontend();
		//$playerId is the partition key
		$gameGroups = $gameGroupFrontend->getAllGroups($frontendId, $playerId);
		//Zenfox_Debug::dump($gameGroups, 'game', true, true);
		if(!$gameGroups)
		{
			$this->_helper->FlashMessenger(array('error' => 'No game found.'));
		}
		$this->view->gameGroups = $gameGroups;
		$this->view->login = $login;
//		$this->view->password = $password; */
		
	}
}