<?php
require_once dirname(__FILE__).'/../forms/AffiliateSchemeForm.php';
require_once dirname(__FILE__).'/../forms/SchemeSearchForm.php';
require_once dirname(__FILE__).'/../forms/EditSchemeDefForm.php';
class Admin_AffiliateschemeController extends Zenfox_Controller_Action
{
	public function viewAction()
	{
		$affiliateScheme = new AffiliateScheme();
		$affiliateSchemes = $affiliateScheme->getAffiliateSchemes();
		$this->view->affiliateSchemes = $affiliateSchemes;
	}
	
	public function createAction()
	{
		$schemeType = new AmsSchemeType();
		$result = $schemeType->getAmsSchemeTypes();
		$form = new Admin_AffiliateSchemeForm();
		$affiliateSchemeForm = $form->setupForm($result);
		$this->view->form = $affiliateSchemeForm;
		
		$request = $this->getRequest();
		if($request->isPost())
		{
			if($affiliateSchemeForm->isValid($_POST))
			{
				$data = $affiliateSchemeForm->getValues();
				$affiliateSchemeConfig = new AffiliateSchemeConfig();
				$affiliateSchemeConfig->insertScheme($data);
				echo 'Scheme is added';
			}
		}
	}
	
	public function searchAction()
	{
		$schemeType = new AmsSchemeType();
		$result = $schemeType->getAmsSchemeTypes();
		$form = new Admin_SchemeSearchForm();		
		$this->view->form = $form->setupForm($result);					
        $scheme = new AffiliateScheme();
        $def = new AffiliateSchemeDef();
        $tableArray = array();	         	
        $schemeArray = array();
		if($this->getRequest()->isPost())
        {
        	if($form->isValid($_POST))
        	{
        		$data = $form->getValues();        
        		$translate = Zend_Registry::get('Zend_Translate');   		     		
        		$results = $scheme->getMatchedSchemes($data['searchField'], $data['searchString'],$data['match']);        		
        		foreach($results as $scheme)        		        		
        		{
        			$schemeDef = $def->getAffiliateSchemeDef($scheme['id']);
        			
        			if($schemeDef[0]['scheme_type'] == $data['schemeType'])
        			{        	
        				$schemeArray[] = $scheme;		
        				foreach($schemeDef as $info)
        				{
        					if($info['scheme_type'] == 'CPA')
        					{
	        					$tableArray[$size][$index][$translate->translate('Slab Id')] = $info['slab_id'];
	        					$tableArray[$size][$index][$translate->translate('Min Players')] = $info['min'];
	        					$tableArray[$size][$index][$translate->translate('Max Players')] = $info['max'];
	        					$tableArray[$size][$index][$translate->translate('Commision')] = $info['factor'];
	        					$tableArray[$size][$index][$translate->translate('Minimum Threshold')] = $info['prerequisite_count'];
	        					$index++;
        					}
        					else if($info['scheme_type'] == 'RS')
        					{
        						$tableArray[$size][$index][$translate->translate('Slab Id')] = $info['slab_id'];
	        					$tableArray[$size][$index][$translate->translate('Min Amount')] = $info['min'];
	        					$tableArray[$size][$index][$translate->translate('Max Amount')] = $info['max'];
	        					$tableArray[$size][$index][$translate->translate('Percentage')] = $info['factor'];	        					
	        					$index++;
        					}        					        						        					
        				}
        				$size++;
        				$index = 0;
        			}        			
        		}        		
        		$this->view->schemeArray = $schemeArray;
        		$this->view->tableArray = $tableArray;        		        		        		        		        		
        	}
        }
	}
	
	public function editAction()
	{
		$affiliateScheme = new AffiliateScheme();
		$affiliateSchemeDef = new AffiliateSchemeDef();
		$request = $this->getRequest();
		$id = $request->id;
		$slabFunc = $request->request;
		if($slabFunc == 'addSlab')
		{
			$result = $affiliateSchemeDef->addSlab($id);
		}
		
		if($slabFunc == 'deleteSlab')
		{			
			$result = $affiliateSchemeDef->deleteSlab($id);
		}
		
		$data = $affiliateScheme->getAffiliateScheme($id);		
		$schemeDef = $affiliateSchemeDef->getAffiliateSchemeDef($id);				
		$this->view->data = $data;
		$this->view->schemeDef = $schemeDef;
		$data = array();		
		if($request->isPost())
		{	
			
			$data['name']  = $request->name;
			$data['desc'] = $request->desc;
			$data['note']  = $request->note;
			$result1 = $affiliateScheme->updateScheme($data,$id);
			foreach($schemeDef as $def)
			{	
				$values = array();
				$str = $def['slab_id'].'min';				
				$values['min'] = $request->$str;
				$str = $def['slab_id'].'max';
				$values['max'] = $request->$str;
				$str = $def['slab_id'].'factor';
				$values['factor'] = $request->$str;
				if($def['scheme_type'] == 'CPA')
				{					
					$str = $def['slab_id'].'prerequisite';
					$values['prerequisite'] = $request->$str;
				}
				else
				{
					$values['prerequisite'] = 0;
				}				
				$result2 = $affiliateSchemeDef->updateSlab($id,$def['slab_id'],$values);
			} 															
			echo 'Scheme is updated';
		}
	}
}