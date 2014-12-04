<?php
/**
 * This class is used to view and modify the player testimonials
 * @author nikhil
 */

require_once dirname(__FILE__) . '/../forms/TestimonialForm.php';

class Admin_TestimonialController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$session = new Zend_Auth_Storage_Session();
		
		$comments = new Comments();
		$offset = $this->getRequest()->pages;
		$itemsPerPage = $this->getRequest()->items;
		if(!$offset && !$itemsPerPage)
		{
			$offset = 1;
			$itemsPerPage = 10;
		}
		
		$testimonialId = $this->getRequest()->id;
		$newStatus = $this->getRequest()->status;

		if($testimonialId && $newStatus)
		{
			$testiData = $comments->getTestiById($testimonialId,true);
		
			$authSession = new Zend_Auth_Storage_Session();
			$sessionData = $authSession->read();
			$csrId = $sessionData['id'];
       		$csrfrontendids = $sessionData["frontend_ids"];
        
       		$player = new Player();
      		$playerdetails = $player->getAccountIdFromLogin($testiData["user_name"]);
       		$playerfrontend = $player->getfrontendidofplayer($playerdetails["player_id"]);
        
			if(in_array($playerfrontend , $csrfrontendids))
			{
				if($comments->changeStatus($testimonialId, $newStatus))
				{
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("The status is updated successfully. You will be redirecting on Testimonial page.")));
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate("Some error occured while updating the status. You will be redirecting on Testimonial page.")));
				}
			}
			else 
			{
				$this->_helper->FlashMessenger(array('error' => "Player not found or You are not authorised to view/edit this player's details"));
			}
				$this->view->refreshPage = true;
				$this->view->link = "/testimonial";
			
		}
		else
		{
			$testimonials = $comments->getAllTestimonials($offset, $itemsPerPage, 'CSR');
			$this->view->contents = $testimonials['content'];
			$this->view->paginator = $testimonials['paginator'];
		}
	}
	
	public function modifyAction()
	{
		$id = $this->getRequest()->id;
		$comments = new Comments();
		$testiData = $comments->getTestiById($id,true);
		
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
        $csrfrontendids = $sessionData["frontend_ids"];
        
        $player = new Player();
        $playerdetails = $player->getAccountIdFromLogin($testiData["user_name"]);
        $playerfrontend = $player->getfrontendidofplayer($playerdetails["player_id"]);
        
		if(in_array($playerfrontend , $csrfrontendids))
		{
		 	$testimonialForm = new Admin_TestimonialForm();
			$testimonialForm->getElement('status')->setValue($testiData['status']);
			$testimonialForm->getElement('reply_msg')->setValue($testiData['comment']);
			$testimonialForm->getElement('testiId')->setValue($id);
			$this->view->form = $testimonialForm;
			if($this->getRequest()->isPost())
			{
				if($testimonialForm->isValid($_POST))
				{
					$formData = $testimonialForm->getValues();
					$editTesti = $comments->editTestiById($formData['testiId'], $formData['reply_msg'], $formData['status']);
					$url = '/testimonial';
					if($editTesti)
					{
						$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Testimonial is updated successfully. To check all testimonials %sClick Here%s.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("Some problem has been occured while updating the testimonial.")));
					}
				}
			}
			
		}
		else 
			{
				$this->_helper->FlashMessenger(array('error' => "Player not found or You are not authorised to view/edit this player's details"));
			}
       
	}
}