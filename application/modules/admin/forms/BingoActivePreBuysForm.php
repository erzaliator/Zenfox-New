<?php 

class Admin_BingoActivePreBuysForm extends Zend_Form
{
	public function getform()
	{
		
		$StartDate =new ZendX_JQuery_Form_Element_DatePicker('startdate',
		 		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		 $StartDate->setLabel('Start Date')
		 ->setRequired(true);
		 
		 $EndDate =new ZendX_JQuery_Form_Element_DatePicker('enddate',
		 		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		 $EndDate->setLabel('End Date')
		 ->setRequired(true);
		 
		 $status = new Zend_Form_Element_MultiCheckbox('status');
		 $status->setLabel('Select Status')
		 		->addMultiOption('enabled','ENABLED')
		 		->addMultiOption('disabled','DISABLED') 
				->setSeparator(' ');
				
		$items = new Zend_Form_Element_Select('items');
		$items->setLabel('Items per page')
			->addMultiOptions(array(
						'10' => '10',
						'20' => '20',
						'30' => '30',
						'-1' => 'ALL'));
				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Get Data');

		$this->addElements(array($StartDate,$EndDate,$status,$items, $submit));
		
		$this->setAction('/bingo/viewactiveprebuys');
		
		return $this;
	}
}