<?php
class Player_iduploadForm extends Zend_Form
{
	public function getform($data = null)
	{
		$decorator = new Zenfox_DecoratorForm();

		$idproofs = new Zend_Form_SubForm();
		$path = Zend_Registry::getInstance()->get('UploadDocumentPath');
			
		$today = new Zend_Date();
		$currentTime = $today->get(Zend_Date::W3C);
			
		$idproof = new Zend_Form_Element_Select('idproof');
		$idproof->setLabel('ID Proof *')
				->setMultiOptions(array('VOTER_ID'=>'VOTER ID','PAN'=>'PAN', 'PASSPORT'=>'PASSPORT', 'DRIVING_LICENSE'=>'DRIVING LICENSE','OTHER'=>'OTHER'))
				->setRequired(true)
				->setvalue($data['kyc_document'])
				->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
				->setAttrib('onChange', 'changeIdProof()');
				
		$idproofother = new Zend_Form_Element_Text('idproofother');
		$idproofother->setLabel($this->getView()->translate('Proof Name * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
					->setvalue($data['kyc_document_other']);
				
		$idproofnumber = new Zend_Form_Element_Text('idproofnumber');
		$idproofnumber->setLabel($this->getView()->translate('Card Number * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
					->setvalue($data['kyc_document_number']);
		
		$idproofauthority = new Zend_Form_Element_Text('idproofauthority');
		$idproofauthority->setLabel($this->getView()->translate('Issuing Authority * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		           		->setvalue($data['issuing_authority']);
					
		
		$idproofexpiry =new ZendX_JQuery_Form_Element_DatePicker('idproofexpiry',
				array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		$idproofexpiry->setLabel('Expiry Date *')
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
						->setvalue($data['expiry_date']);
		
					
		$file1name = "IDPROOF1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
		$file1 = new Zend_Form_Element_File('ID1');
		$file1->setLabel($this->getView()->translate('ID PROOF 1 *'))
				->setRequired(true)
				->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
				->addFilter('rename',$file1name)
				->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
				->setDestination($path);
			
		$file2name = "IDPROOF2_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
		$file2 = new Zend_Form_Element_File('ID2');
		$file2->setLabel($this->getView()->translate('ID PROOF 2'))
				->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
				->addFilter('rename',$file2name)
				->setDestination($path);

		$file3name = "IDPROOF3_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
		$file3 = new Zend_Form_Element_File('ID3');
		$file3->setLabel($this->getView()->translate('ID PROOF 3'))
				->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
				->addFilter('rename',$file3name)
				->setDestination($path);

 		$file3->setDecorators($decorator->openingFileDecorator);
  		$file2->setDecorators($decorator->openingFileDecorator);
  		$file1->setDecorators($decorator->openingFileDecorator);
		$idproof->setDecorators($decorator->openingUlTagDecorator);
		$idproofother->setDecorators($decorator->changeIdProofDecorator);
		$idproofauthority->setDecorators($decorator->changeIdProofAuthDecorator);
		$idproofexpiry->setDecorators($decorator->changeIdProofExpDecorator);
		$idproofnumber->setDecorators($decorator->changeIdProofNoDecorator);
					
		$idproofs->addElements(array($idproof,$idproofother,$idproofnumber,$idproofexpiry,$idproofauthority,$file1,$file2,$file3));
		$idproofs->setAttrib('enctype', 'multipart/form-data');
		
		return $idproofs;
	}
}