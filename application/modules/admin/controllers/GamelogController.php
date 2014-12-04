<?php

require_once dirname(__FILE__) . '/../forms/DateSelectionForm.php';
class Admin_GamelogController extends Zenfox_Controller_Action
{
	public function init()
		{
			parent::init();
			$this->_redirector = $this->_helper->getHelper('Redirector');
	        $contextSwitch = $this->_helper->getHelper('contextSwitch');
	       $contextSwitch->setAutoJsonSerialization(false);
			$contextSwitch->addActionContext('index', 'json')				
	              	->initContext();
	      //  Zend_Layout::getMvcInstance()->disableLayout();
		}
	public function indexAction()
	{
		
		$playerId = $this->getRequest()->playerId;
		$type = $this->getRequest()->type;
		//$type = 'keno';
		
		if($type == 'keno')
		{
			$logObjKeno = new GamelogKeno();
			$logKeno = $logObjKeno->getKenologDetails($playerId);
			
			$this->view->log = $logKeno;
			$this->view->of = 'keno';
		}

		if($type == 'roulette')
		{
			
			$logObjRoulette = new GamelogRoulette();
			$logRoulette = $logObjRoulette->getRoulettelogDetails($playerId);
			
			$this->view->log = $logRoulette;
			$this->view->of = 'roulette';
		}
		
		if($type == 'slot')
		{
			$logObjSlot = new GamelogSlot();
			$logSlot = $logObjSlot->getSlotlogDetails($playerId);
			
			$this->view->log = $logSlot;
			$this->view->of = 'slot';
		}
	}
	
	public function kenoAction()
	{
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		$offset = $this->getRequest()->page;
		$logObjKeno = new GamelogKeno();
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$offset = 1;
				$formData = $form->getValues();
				$playerId = $formData['playerId'];
				$fromDate = $formData['from_date'] . ' ' . $formData['from_time'];
				$toDate = $formData['to_date'] . ' ' . $formData['to_time'];
				$itemsPerPage = $formData['items'];
				
				$logKeno = $logObjKeno->getKenolog($playerId, $fromDate, $toDate, $itemsPerPage, $offset);
				
				if($logKeno)
				{
					$this->view->paginator = $logKeno['paginator'];
					$this->view->contents = $logKeno['logData'];
					$this->view->from = $fromDate;
					$this->view->to = $toDate;
					$this->view->playerId = $playerId;
				}
			}
		}
		else if($offset)
		{
			$fromDate = $this->getRequest()->from;
			$toDate = $this->getRequest()->to;
			$itemsPerPage = $this->getRequest()->item;
			$playerId = $this->getRequest()->playerId;
			
			$logKeno = $logObjKeno->getKenolog($playerId, $fromDate, $toDate, $itemsPerPage, $offset);
			
			if($logKeno)
			{
				$this->view->paginator = $logKeno['paginator'];
				$this->view->contents = $logKeno['logData'];
				$this->view->from = $fromDate;
				$this->view->to = $toDate;
				$this->view->playerId = $playerId;
			}
		}
	}
	
	public function slotAction()
	{
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		$offset = $this->getRequest()->page;
		$logObjSlot = new GamelogSlot();
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$offset = 1;
				$formData = $form->getValues();
				$playerId = $formData['playerId'];
				$fromDate = $formData['from_date'] . ' ' . $formData['from_time'];
				$toDate = $formData['to_date'] . ' ' . $formData['to_time'];
				$itemsPerPage = $formData['items'];
				
				$logSlot = $logObjSlot->getSlotlog($playerId, $fromDate, $toDate, $itemsPerPage, $offset);
				
				if($logSlot)
				{
					$this->view->paginator = $logSlot['paginator'];
					$this->view->contents = $logSlot['logData'];
					$this->view->from = $fromDate;
					$this->view->to = $toDate;
					$this->view->playerId = $playerId;
				}
			}
		}
		else if($offset)
		{
			$fromDate = $this->getRequest()->from;
			$toDate = $this->getRequest()->to;
			$itemsPerPage = $this->getRequest()->item;
			$playerId = $this->getRequest()->playerId;
				
			$logSlot = $logObjSlot->getSlotlog($playerId, $fromDate, $toDate, $itemsPerPage, $offset);
				
			if($logSlot)
			{
				$this->view->paginator = $logSlot['paginator'];
				$this->view->contents = $logSlot['logData'];
				$this->view->from = $fromDate;
				$this->view->to = $toDate;
				$this->view->playerId = $playerId;
			}
		}
	}
	
	public function rouletteAction()
	{
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		$offset = $this->getRequest()->page;
		$logObjRoulette = new GamelogRoulette();
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$offset = 1;
				$formData = $form->getValues();
				$playerId = $formData['playerId'];
				$fromDate = $formData['from_date'] . ' ' . $formData['from_time'];
				$toDate = $formData['to_date'] . ' ' . $formData['to_time'];
				$itemsPerPage = $formData['items'];
				
				$logRoulette = $logObjRoulette->getRoulettelog($playerId, $fromDate, $toDate, $itemsPerPage, $offset);
				
				if($logRoulette)
				{
					$this->view->paginator = $logRoulette['paginator'];
					$this->view->contents = $logRoulette['logData'];
					$this->view->from = $fromDate;
					$this->view->to = $toDate;
					$this->view->playerId = $playerId;
				}
			}
		}
		else if($offset)
		{
			$fromDate = $this->getRequest()->from;
			$toDate = $this->getRequest()->to;
			$itemsPerPage = $this->getRequest()->item;
			$playerId = $this->getRequest()->playerId;
		
			$logRoulette = $logObjRoulette->getRoulettelog($playerId, $fromDate, $toDate, $itemsPerPage, $offset);
				
			if($logRoulette)
			{
				$this->view->paginator = $logRoulette['paginator'];
				$this->view->contents = $logRoulette['logData'];
				$this->view->from = $fromDate;
				$this->view->to = $toDate;
				$this->view->playerId = $playerId;
			}
		}
	}
}