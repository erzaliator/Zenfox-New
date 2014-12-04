<?php
require_once dirname(__FILE__).'/../forms/TrackerSearchForm.php';

class Admin_TrackersearchController extends Zenfox_Controller_Action
{
	public function init()
	{
		
	}
	public function indexAction()
	{
		$form = new Admin_TrackerSearchForm();
		$affiliateTracker = new AffiliateTracker();
		$this->view->form = $form;
		
		$request = $this->getRequest();
		$offset = $request->page;
        $itemsPerPage = $request->item;
		
		if(!$offset)
        {
        	$offset = 1;
        }
        else
        {
        	$searchField = $request->field;
        	$searchString = $request->str;
        	$match = $request->match;
        	$order = $request->order;
        	$result = $affiliateTracker->getMatchedTrackers($searchField, $offset, $itemsPerPage, 
    	    								$searchString,$match,$order);
        	$this->view->searchField = $searchField;
        	$this->view->searchStr = $searchString;
        	$this->view->match = $match;
        	$this->view->paginator = $result[0];
        	$this->view->contents = $result[1];        	          	        	
        }
		
		if($this->getRequest()->isPost())
        {
        	if($form->isValid($_POST))
        	{
        		$data = $form->getValues();        		
        		$result = $affiliateTracker->getMatchedTrackers($data['searchField'], $offset, $data['items'], 
        														$data['searchString'],$data['match'],$data['order']);
        		$this->view->searchField = $data['searchField'];
        		$this->view->searchStr = $data['searchString'];        		
        		$this->view->match = $data['match'];
        		$this->view->order = $data['order'];
        		$this->view->paginator = $result[0];
        		$this->view->contents = $result[1];         		        		
        	}        	
        	if(count($result[1]) == 1)
			{
				foreach($result[1] as $data){					
					$id = $data['Link Id'];
				}										
				$this->_redirect("affiliatetracker/viewtracker/id/$id");
			}        		        		        		    
        }                
	}
}