<?php
require_once dirname(__FILE__) . '/../forms/SystemReportForm.php';
class Admin_SystemController extends Zenfox_Controller_Action
{
	public function getreportAction()
	{
		$session = new Zend_Session_Namespace('Tags');
		$form = new Admin_SystemReportForm();
		$this->view->form = $form;
		$systemHealth = new SystemHealth();
		$offset = $this->getRequest()->pages;
		if($offset)
		{
//			echo "here";
//			print('offset - ' . $offset);
			$tagName = $this->getRequest()->tag;
			$from = $this->getRequest()->from;
			$to = $this->getRequest()->to;
			$reportType = $this->getRequest()->rType;
			$itemsPerPage = $this->getRequest()->item;
			//Zenfox_Debug::dump($session->tags, 'session');
			if($tagName)
			{
				foreach($session->tags as $storedTag => $storedOffset)
				{
					/*print('storedTag - ' . $storedTag);
					print('tagName - ' . $tagName);*/
					$offset = $this->getRequest()->pages;
					if($storedTag != $tagName)
					{
						//echo "inside";
						$offset = $storedOffset;
					}
					$result = $systemHealth->getSystemReportByTag($storedTag, $reportType, $from, $to, $offset, $itemsPerPage);
					$finalReports[] = $result;
					$store[$storedTag] = $offset;
				}
				$this->view->currentPage = $session->offset;
			}
			else
			{
				foreach($session->tags as $storedTag => $storedOffset)
				{
					$result = $systemHealth->getSystemReportByTag($storedTag, $reportType, $from, $to, $offset, $itemsPerPage);
					$finalReports[] = $result;
					$store[$storedTag] = $offset;
				}
				$this->view->currentPage = $offset;
				$session->offset = $offset;
			}
			//exit();
			$session->tags = $store;
			$this->view->item = $itemsPerPage;
			$this->view->fromDate = $from;
			$this->view->toDate = $to;
			$this->view->reportType = $reportType;
			$this->view->finalReports = $finalReports;
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$finalReports = array();
				$session->unsetAll();
				$offset = 1;
				$data = $form->getValues();
				$from = $data['fromDate'] . ' ' . $data['fromTime'];
				$to = $data['toDate'] . ' ' . $data['toTime'];
				//Zenfox_Debug::dump($data, 'data');
				if($data['tagName'])
				{
					foreach($data['tagName'] as $tagName)
					{
						$result = $systemHealth->getSystemReportByTag($tagName, $data['reportType'], $from, $to, $offset, $data['page']);
						$finalReports[] = $result;
						$store[$tagName] = $offset;
					}
				}
				$session->tags = $store;
				$session->offset = $offset;
				$this->view->item = $data['page'];
				$this->view->currentPage = $offset;
				$this->view->fromDate = $from;
				$this->view->toDate = $to;
				$this->view->reportType = $data['reportType'];
				$this->view->finalReports = $finalReports;
			}
		}
	}
}