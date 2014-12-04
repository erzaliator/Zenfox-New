<?php
require_once dirname(__FILE__).'/../forms/BankdetailssearchForm.php';

class Admin_BankdetailssearchController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$form = new Admin_BankdetailssearchForm();
		$this->view->form = $form->getform();
		
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$sessionName = 'Searching_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
				
		 $offset = $this->getRequest()->page;
		 		
		if($this->getRequest()->isPost())
        {
        	if($form->isValid($_REQUEST))
        	{ 
        		
        		$data = $form->getValues();
        		
        		
		
		
        		$bankdetailsobj = new BankDetails();
        		$offset =1;
        		$values = $bankdetailsobj->searchbankdetails($data["searchField"],$data["searchString"],$data["items"],$offset,$session);
        		
        		if($values)
        		{
        			$this->view->paginator = $values[0];
        			$this->view->searchField = $data['searchField'];
        			$this->view->searchStr = $data['searchString'];
        			$this->view->contents = $values[1];
        		}
        		else
        		{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate("No Details Found")));
        		}
        	}
        }
		elseif($offset)
        {
        	$itemsPerPage = $this->getRequest()->item;
        	$searchField = $this->getRequest()->field;
        	$searchString = $this->getRequest()->str;
        	
        	$bankdetailsobj = new BankDetails();
        	$values = $bankdetailsobj->searchbankdetails($searchField,$searchString,$itemsPerPage, $offset , $session);
        	
        	if(!$values)
        	{
        		$this->_redirect($language . '/error/error');
        	}

        	$this->view->paginator = $values[0];
        	$this->view->searchField = $searchField;
        	$this->view->searchStr = $searchString;
        	$this->view->contents = $values[1];
        }
	}
}