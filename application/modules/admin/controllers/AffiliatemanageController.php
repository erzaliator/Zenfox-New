<?php
require_once dirname(__FILE__).'/../../affiliate/forms/RegistrationForm.php';
require_once dirname(__FILE__).'/../../affiliate/forms/TransactionForm.php';
require_once dirname(__FILE__).'/../../affiliate/forms/ChangePasswordForm.php';

class Admin_AffiliatemanageController extends Zenfox_Controller_Action
{
	public function viewprofileAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		$affiliate = new Affiliate();
		$affiliateDetails = $affiliate->getAffiliate($id);
		$this->view->affiliateDetails = $affiliateDetails;	
	}
	
	public function changepasswordAction()
	{
		$affiliateConfig = new AffiliateConfig();
		$request = $this->getRequest();
		$id = $request->id;
		$form = new Affiliate_ChangePasswordForm();
		$form = $form->getForm();
		$this->view->form = $form;
		if($request->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$result = $affiliateConfig->updatePassword($id,$data);
				if($result[0])
				{					
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your password has been successfully changed")));
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate("Some Error occured !! Please Try Again")));					
				}
			}
		}
	}
	
	public function editprofileAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		$affiliate = new Affiliate();
		$affiliateDetails = $affiliate->getAffiliate($id);
		$this->view->affiliateDetails = $affiliateDetails;
		
		$form = new Affiliate_RegistrationForm();
		$registrationForm = $form->setForm($affiliateDetails);
		$this->view->form = $registrationForm;
		
		if($request->isPost())
		{
			if($registrationForm->isValid($_POST))
			{
				$data = $registrationForm->getValues();
				$affiliateConfig = new AffiliateConfig();
				$affiliateConfig->updateProfile($id,$data);
				echo 'Profile Updated';
			}
		}
	}
	
	public function reconcilereportAction()
	{
		$form = new Affiliate_AffiliateTransactionForm();
		$form = $form->getForm();
		$this->view->form = $form;
		$transaction = new AffiliateTransaction();
		$request = $this->getRequest();
		$affiliateId = $request->id;
		$offset = $request->page;
        $itemsPerPage = $request->item;
        
	 	if(!$offset)
        {
        	$offset = 1;
        }
        else
        {
        	$fromDate = $request->fromDate;
        	$toDate = $request->toDate;
        	$paginator = $transaction->getTransactionsWithinDateRange($affiliateId,$fromDate,$toDate,$offset,$itemsPerPage);
        	$this->view->paginator = $paginator;
        	$this->view->fromDate = $fromDate;
        	$this->view->toDate = $toDate;
        }
		if($request->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$fromDate = $data['fromDate'];
				$toDate = $data['toDate'];
				$fromTime = $data['fromTime'].':00';
				$toTime = $data['toTime'].':00';
				$fromDate = $fromDate.' '.$fromTime;
				$toDate = $toDate.' '.$toTime;
				$itemsPerPage = $data['items'];
				$paginator = $transaction->getTransactionsWithinDateRange($affiliateId,$fromDate,$toDate,$offset,$itemsPerPage);
				$this->view->paginator = $paginator;
				$this->view->fromDate = $fromDate;
        		$this->view->toDate = $toDate;
			}
		}
	}
	
	public function earningsAction()
	{
		$request = $this->getRequest();
		$affiliateId = $request->id;
		
		$earningsSummary = new EarningsSummary();
		$earnings = $earningsSummary->getAffiliateEarnings($affiliateId);
		//echo $earnings;
		
		$subAffiliateEarnings = $earningsSummary->getSubAffiliateEarnings($affiliateId);
		
		$totalSubEarnings = 0;
		
		foreach($subAffiliateEarnings as $subAffEarning)
		{
			$totalSubEarnings += $subAffEarning['earnings'];
		}
		$this->view->earnings = $earnings;
		$this->view->subAffiliateEarnings = $subAffiliateEarnings;
		$this->view->totalSubEarnings = $totalSubEarnings;
	}
}