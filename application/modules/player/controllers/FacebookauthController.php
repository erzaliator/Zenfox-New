<?php
require_once dirname(__FILE__).'/../forms/ConnFacebookUserForm.php';
class Player_FacebookauthController extends Zenfox_Controller_Action
{
	public function authAction()
	{
		//TODO Remove it from here
		$form = new Player_ConnFacebookUserForm();
		$this->view->form = $form;
		$session = new Zenfox_Auth_Storage_Session();
		$sessionData = $session->read();
		$userId = $sessionData['id'];
		$facebookConnect = new ThirdpartyConnect();
		$iData['playerId'] = $userId;
		$iData['domain'] = 'facebook';
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				
				$player = new Player();
				$authArray = $player->authenticate($data['name'], $data['password']);
				$zendAuthResult = $authArray[0];
				if($zendAuthResult->getCode()== Zend_Auth_Result::SUCCESS)
				{
					$parentId = $authArray[1][0]['player_id'];
					$data['parentId'] = $parentId;
					$data['linked'] = 'YES';
					$data['domain'] = 'facebook';
					$data['playerId'] = $userId;
					//Zenfox_Debug::dump($data, 'data');
					$facebookConnect->updateData($data);
					$this->view->submit = true;
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate('The username or password, you entered, did not match.')));
				}
			}
		}
		else
		{
			$facebookConnect->insertData($iData);
		}
	}
}
