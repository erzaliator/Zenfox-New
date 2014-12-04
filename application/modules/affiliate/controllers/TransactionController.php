<?php
require_once dirname(__FILE__).'/../forms/TransactionForm.php';

class Affiliate_TransactionController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$form = new Affiliate_TransactionForm();
		$form = $form->getForm();
		$this->view->form = $form;
		$storage = new Zenfox_Auth_Storage_Session();
		$session = $storage->read();
		$affiliateId = $session['id'];
		$transaction = new AffiliateTransaction();
		$request = $this->getRequest();
		$offset = $request->page;
        $itemsPerPage = $request->item;
        
		if($request->isPost())
		{
			if($form->isValid($_POST))
			{
				$offset = 1;
				$data = $form->getValues();
				$fromDate = $data['fromDate'];
				$toDate = $data['toDate'];
				$fromTime = $data['fromTime'].':00';
				$toTime = $data['toTime'].':00';
				$fromDate = $fromDate.' '.$fromTime;
				$toDate = $toDate.' '.$toTime;
				$itemsPerPage = $data['items'];
				$paginator = $transaction->getTransactionsWithinDateRange($affiliateId,$fromDate,$toDate,$offset,$itemsPerPage);
				$this->view->paginator = $paginator[0];
				$this->view->content = $paginator[1];
				$this->view->fromDate = $fromDate;
        		$this->view->toDate = $toDate;
			}
		}
		else
		{
			$fromDate = $request->fromDate;
			$toDate = $request->toDate;
			$paginator = $transaction->getTransactionsWithinDateRange($affiliateId,$fromDate,$toDate,$offset,$itemsPerPage);
			$this->view->paginator = $paginator[0];
			$this->view->content = $paginator[1];
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
		}
	}
}