<?php

require_once dirname(__FILE__) . '/../forms/AnalyticsForm.php';

class Partner_AnalyticsController extends Zend_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function registrationsAction()
	{
		$analyticsForm = new Partner_AnalyticsForm();
		$analyticsForm->getElement('frontendId')->addMultiOptions(array('7' => 'Ace2Jak'));
		$this->view->analyticsForm = $analyticsForm;
		
		if($this->getRequest()->isPost())
		{
			if($analyticsForm->isValid($_POST))
			{
				$formValues = $analyticsForm->getValues();
		
				$syshealth= new SystemHealth();
					
				$healthresult = $syshealth->getregistrationsummary('Frontend',$formValues["frontendId"],$formValues["reportType"],$formValues['from_date'],$formValues['to_date']);
				if(!empty($healthresult))
				{
					$this->view->value = $healthresult;
				}
				else
				{
					$this->view->analyticsForm = 'No Records found.';
				}
			}
		}
	}
	
	public function transactionsAction()
	{
		$analyticsForm = new Partner_AnalyticsForm();
		$analyticsForm->getElement('frontendId')->addMultiOptions(array('7' => 'Ace2Jak'));
		$this->view->analyticsForm = $analyticsForm;
		
		if($this->getRequest()->isPost())
		{
			if($analyticsForm->isValid($_POST))
			{
				$formValues = $analyticsForm->getValues();
		
				$syshealth= new SystemHealth();
					
				$healthresult = $syshealth->getsystemtransactionslist('Frontend',$formValues["frontendId"],$formValues["reportType"],$formValues['from_date'],$formValues['to_date']);
				if(!empty($healthresult))
				{
					$this->view->value = $healthresult;
				}
				else
				{
					$this->view->analyticsForm = 'No Records found.';
				}
			}
		}
	}
	
	public function transactingPlayersAction()
	{
		$analyticsForm = new Partner_AnalyticsForm();
		$analyticsForm->getElement('frontendId')->addMultiOptions(array('7' => 'Ace2Jak'));
		$this->view->analyticsForm = $analyticsForm;
		
		if($this->getRequest()->isPost())
		{
			if($analyticsForm->isValid($_POST))
			{
				$formValues = $analyticsForm->getValues();
				
				$syshealth= new SystemHealth();
					
				$healthresult = $syshealth->gettransactingplayers('Frontend',$formValues["frontendId"],$formValues["reportType"],$formValues['from_date'],$formValues['to_date']);				
				if(!empty($healthresult))
				{
					$this->view->value = $healthresult;
				}
				else
				{
					$this->view->analyticsForm = 'No Records found.';
				}
			}
		}
	}
}
