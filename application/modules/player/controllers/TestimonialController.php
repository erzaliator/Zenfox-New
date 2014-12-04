<?php
require_once dirname(__FILE__) . '/../forms/TestimonialForm.php';
class Player_TestimonialController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$comments = new Comments();
		$testimonials = $comments->getTestimonials();
		$testimonialsData = array();
		$i = 0;
		$player = new Player();
		foreach($testimonials as $testimonial)
		{
			$playerId = $player->getAccountIdFromLogin($testimonial['user_name']);
			$accountDetails = $player->getPlayerData($playerId);

			$firstName = $accountDetails['firstName'];
			$name = empty($firstName)?$testimonial['user_name']:$firstName;

			$testimonialsData[$i]['playerId'] = $playerId;
			$testimonialsData[$i]['name'] = $name;
			$testimonialsData[$i]['testi'] = $testimonial['comment'];
			$i++;
		}
		$this->view->testies = $testimonialsData;
	}
	
	public function writeAction()
	{
		$form = new Player_TestimonialForm();
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$data['page'] = 'player-testimonial-index';
				$data['comment'] = stripslashes($data['comment']);

				$conn = Zenfox_Partition::getInstance()->getMasterConnection();
				Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				$comments = new Comments();
				$result = $comments->insertData($data);

				if(!$result)
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate('Your comments are not saved. You will be redirected on your previous page.')));
					$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/comments/testimonials';
				}
				
				else
				{
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate('We appreciate your comments. Thank you!! You will be redirected on your main page.')));
					$this->view->link = 'http://' . $_SERVER['SERVER_NAME'];
				}
				$this->view->form = '';
			}
		}
	}
	
	public function viewAction()
	{
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$playerId = $sessionData['id'];
		$this->view->playerId = $playerId;
		
		$comments = new Comments();
		$offset = 0;
		$pageNo = $this->getRequest()->pages;
		$item = $this->getRequest()->item;
		$offset = ($pageNo)?$pageNo : 0;

		$itemsPerPage = ($item)?$item : 8;
		$scrolling = $this->getRequest()->scroll;
		if($scrolling)
		{
			$this->view->scrolling = true;
			$itemsPerPage = ($item)?$item : 4;
		}
		
		$testimonials = $comments->getAllTestimonials($offset, $itemsPerPage);

		if($testimonials)
		{
			$this->view->paginator = $testimonials['paginator'];
			$this->view->testies = $testimonials['content'];
		}
		elseif(!$scrolling)
		{
			$this->_helper->FlashMessenger(array('notice' => $this->view->translate('There is no testimonial yet.')));
		}
	}
}
