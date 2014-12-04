<?php
class Admin_UpdateProofForm extends Zend_Form
{
	public function getform($data = null)
	{
		$status = new Zend_Form_Element_Select('status');
		$status->setLabel('Status')
		->setMultiOptions(array( 'PENDING'=>'PENDING','ACCEPTED'=>'ACCEPTED', 'REJECTED'=>'REJECTED'))
		->setRequired(true)
		->setvalue($data["Status"])
		->addValidator('NotEmpty');
		
		$IDType = new Zend_Form_Element_Text('type');
		$IDType->setLabel('ID Type')
		->setvalue($data["IDtype"]);
		
		$IDNumber = new Zend_Form_Element_Text('Number');
		$IDNumber->setLabel('ID Number')
		->setvalue($data["IDnumber"]);
		
		$IssuingAuthority = new Zend_Form_Element_Text('Authority');
		$IssuingAuthority->setLabel('Issuing Authority')
		->setvalue($data["IssuingAuthority"]);
		
		$expiryDate = new ZendX_JQuery_Form_Element_DatePicker('expiryDate',
		 		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		$expiryDate->setLabel('Expiry Date')
		->setvalue($data["ExpiryDate"]);

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Insert');

		$this->addElements(array($status, $IDType, $IDNumber,$expiryDate,$IssuingAuthority,$submit));

		return $this;
	}
}