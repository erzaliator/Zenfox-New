<?php
require_once dirname(__FILE__).'/../forms/AmsSchemeTypesForm.php';

class Admin_AmsschemeController extends Zenfox_Controller_Action
{
	public function viewAction()
	{
		$amsSchemeType = new AmsSchemeType();
		$amsSchemeTypes = $amsSchemeType->getAmsSchemeTypes();
		$this->view->amsSchemeTypes = $amsSchemeTypes;
	}
	
	public function createAction()
	{
		$form = new Admin_AmsSchemeTypesForm();
		$amsSchemeTypeForm = $form->getForm();
		$this->view->form = $amsSchemeTypeForm;
		
		$request = $this->getRequest();
		if($request->isPost())
		{
			if($amsSchemeTypeForm->isValid($_POST))
			{
				$data = $amsSchemeTypeForm->getValues();
				$amsSchemeTypeConfig = new AmsSchemeTypeConfig();
				$amsSchemeTypeConfig->insertAmsSchemeType($data);
				$this->view->form = '';
				echo 'Ams Scheme is added';
			}
		}
	}
	
	public function editAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		$amsSchemeType = new AmsSchemeType();
		$data = $amsSchemeType->getAmsSchemeType($id);
		$form = new Admin_AmsSchemeTypesForm();
		$amsSchemeTypeForm = $form->setForm($data);
		$this->view->form = $amsSchemeTypeForm;
		
		if($request->isPost())
		{
			if($amsSchemeTypeForm->isValid($_POST))
			{
				$data = $amsSchemeTypeForm->getValues();
				$amsSchemeTypeConfig = new AmsSchemeTypeConfig();
				$amsSchemeTypeConfig->updateAmsSchemeType($id, $data);
				$this->view->form = '';
				echo 'Ams Scheme is updated';
			}
		}
	}
}