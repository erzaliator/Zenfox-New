<?php
require_once dirname(__FILE__).'/../forms/FrontendForm.php';

class Admin_FrontendController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function viewAction()
	{
		$frntend = new Frontend();
		$frntends = $frntend->getFrontends();
		$this->view->frontends = $frntends;
	}
	
	public function createAction()
	{
		$form = new Admin_FrontendForm();
		$frntendForm = $form->getForm();
		$this->view->form = $frntendForm;
		if($this->getRequest()->isPost())
		{
			//echo 'it is post';
			if($frntendForm->isValid($_POST))
			{
				//echo 'is valid';
				$data = $frntendForm->getValues();
				//print_r($_POST);
				$frntendConfig = new FrontendConfig();
				$frntendConfig->insertData($_POST);
				$this->view->form = ''; 
				echo 'data is saved';
			}
			else
			{
				echo 'enter valid data';
			}
		}
//		else
//		{
//			$this->view->form = $frntendForm;
//		}
	}
	
	public function editAction()
	{
		$form = new Admin_FrontendForm();
		$request = $this->getRequest();
		$id = $request->id;
		$frntend = new Frontend();
		$result = $frntend->getFrontendById($id);
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
				$frntendConfig = new FrontendConfig();
				$frntendConfig->updateData($id,$_POST); 
				$this->view->form = '';
				echo 'data is updated';
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
		$frntend = new Frontend();
		$result = $frntend->getFrontendById($id);
		$this->view->frontendDetails = $result;
		$idString = $result['allowed_frontend_ids'];
		$ids = explode(",",$idString);
		$allowedFrntends = array();
		foreach($ids as $id)
		{
			$allowedFrntends[] = $frntend->getFrontendById($id);
		}
		$this->view->allowedFrntends = $allowedFrntends;
		
		//$id = $_REQUEST['id'];
	}
}