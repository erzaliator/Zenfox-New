<?php
require_once dirname(__FILE__) . '/../forms/CommentsForm.php';
require_once dirname(__FILE__) . '/../forms/TestimonialForm.php';
class Player_CommentsController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$form = new Player_CommentsForm();
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				//Zenfox_Debug::dump($data, 'data', true, true);
				$comments = new Comments();
				$result = $comments->insertData($data);
				//$result = true;
				if(!$result)
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate('Your comments are not saved. You will be redirected on your previous page.')));
				}
				
				else
				{
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate('We appriciate your comments. Thank you!! You will be redirected on your previous page.')));
				}
				$this->view->form = '';
				$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . $data['url'];
			}
		}
	}
	
	public function showAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$pageAddress = $this->getRequest()->url;
		$front = Zend_Controller_Front::getInstance()->getRequest();
		if(!$pageAddress)
		{
			$module = $front->getModuleName();
			$controller = $front->getControllerName();
			$action = $front->getActionName();
			$pageAddress = $module . '-' . $controller . '-' . $action;
		}
		$offset = $front->getParam('pages');
		$session = new Zend_Auth_Storage_Session();
		if($session->read())
		{
			$itemsPerPage = 5;
		}
		else
		{
			$itemsPerPage = 3;
		}
		$this->view->jsScript = true;
		if(!$offset)
		{
			$this->view->jsScript = false;
			//Set the number of items to be displayed
			$offset = 1;
		}
		$comments = new Comments();
		$result = $comments->getCommentsByPage($pageAddress, $offset, $itemsPerPage);
		$this->view->paginator = $result['paginator'];
		$this->view->contents = $result['content'];
		$this->view->pageAddress = $pageAddress;
		$session = new Zend_Session_Namespace('CommentsData');
		$session->value = $result['content'];
	}
}
