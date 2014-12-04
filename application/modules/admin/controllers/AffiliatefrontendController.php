<?php
require_once dirname(__FILE__).'/../forms/AffiliateFrontendForm.php';

class Admin_AffiliatefrontendController extends Zenfox_Controller_Action
{
	public function viewAction()
	{
		$affFrontend = new AffiliateFrontend();
		$affFrntends = $affFrontend->getAffiliateFrontends();
		$this->view->affFrontends = $affFrntends;
	}
	
	public function createAction()
	{
		$form = new Admin_AffiliateFrontendForm();
		$affFrontendForm = $form->getForm();
		$this->view->form = $affFrontendForm;
		if($this->getRequest()->isPost())
		{
			//echo 'it is post';
			if($affFrontendForm->isValid($_POST))
			{
				//echo 'is valid';
				$data = $affFrontendForm->getValues();
				//print_r($_POST);
				$affFrntendConfig = new AffiliateFrontendConfig();
				$affFrntendConfig->insertData($_POST);
				$this->view->form = ''; 
				echo 'data is saved';
			}
			else
			{
				echo 'enter valid data';
			}
		}

	}
	
	public function viewdetailsAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		$affFrontend = new AffiliateFrontend();
		$frntend = new Frontend();
		$result = $affFrontend->getAffiliateFrontendById($id);
		$this->view->affFrontendDetails = $result;
		$allowedFrontendIdString = $result['allowed_frontend_ids'];
		$frntendIds = explode(",",$allowedFrontendIdString);
		$allowedFrntends = array();
		foreach($frntendIds as $frntendId)
		{
			$allowedFrntends[] = $frntend->getFrontendById($frntendId);
		}
		
		$this->view->allowedFrntends = $allowedFrntends;
		
		$allowedAffiliateFrontendIdString = $result['affiliate_allowed_frontend_ids'];
		$affFrntendIds = explode(",",$allowedAffiliateFrontendIdString);
		$allowedAffFrntends = array();
		foreach($affFrntendIds as $affFrntendId)
		{
			$allowedAffFrntends[] = $affFrontend->getAffiliateFrontendById($affFrntendId);
		}
		$this->view->allowedAffFrntends = $allowedAffFrntends;
		
		//$id = $_REQUEST['id'];
	}
	
	public function editAction()
	{
		$form = new Admin_AffiliateFrontendForm();
		$request = $this->getRequest();
		$id = $request->id;
		$affFrntend = new AffiliateFrontend();
		$result = $affFrntend->getAffiliateFrontendById($id);
		$form = $form->setForm($result);
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			//echo 'it is post';
			if($form->isValid($_POST))
			{
				//echo 'is valid';
				$data = $form->getValues();
				//print_r($_POST);
				$affFrntendConfig = new AffiliateFrontendConfig();
				$affFrntendConfig->updateData($id,$_POST); 
				$this->view->form = '';
				echo 'data is updated';
			}
			else
			{
				echo 'enter valid data';
			}
		}
		
	}
}