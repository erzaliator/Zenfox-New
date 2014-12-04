<?php
class Player_addressuploadForm extends Zend_Form
{
	public function getform($data = null)
	{
		$decorator = new Zenfox_DecoratorForm();

			$addressproofs = new Zend_Form_SubForm();

			$path = Zend_Registry::getInstance()->get('UploadDocumentPath');
			
			
			$today = new Zend_Date();
			$currentTime = $today->get(Zend_Date::W3C);
			
			$addressproof = new Zend_Form_Element_Select('addressproof');
				$addressproof->setLabel('Address Proof *')
				->setMultiOptions(array('VOTER_ID'=>'VOTER ID', 'PASSPORT'=>'PASSPORT', 'DRIVING_LICENSE'=>'DRIVING LICENSE','OTHER'=>'OTHER'))
				->setRequired(true)
				->setvalue($data['kyc_document'])
				->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
				->setAttrib('onChange', 'changeIdProof()');
				
				$addressproofother = new Zend_Form_Element_Text('otheraddressproof');
				$addressproofother->setLabel($this->getView()->translate('Proof Name *'))
				->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
				->addValidator(new Zenfox_Validate_CharactercheckValidator)
				->setvalue($data['kyc_document_other']);
				
				$addressproofnumber = new Zend_Form_Element_Text('addressproofnumber');
				$addressproofnumber->setLabel($this->getView()->translate('Card Number *'))
				->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
					->addValidator(new Zenfox_Validate_CharactercheckValidator)
				->setvalue($data['kyc_document_number']);
		
				$addressproofauthority = new Zend_Form_Element_Text('addressproofauthority');
				$addressproofauthority->setLabel($this->getView()->translate('Issuing Authority *'))
				->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
				->addValidator(new Zenfox_Validate_CharactercheckValidator)
				->setvalue($data['issuing_authority']);
					
				
				$addressproofexpiry =new ZendX_JQuery_Form_Element_DatePicker('addressproofexpiry',
						array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
				$addressproofexpiry->setLabel('Expiry Date *')
								->setvalue($data['expiry_date']);
				
				$file1name = "ADDRESSPROOF1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
				$file1 = new Zend_Form_Element_File('ADDR1');
				$file1->setLabel($this->getView()->translate('File1 *'))
				->setRequired(true)
				->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
				->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
				->addFilter('rename',$file1name)
				->setAttrib('size', '11')
				->setDestination($path);
			
				$file2name = "ADDRESSPROOF2_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
				$file2 = new Zend_Form_Element_File('ADDR2');
				$file2->setLabel($this->getView()->translate('File2'))
				->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
				->addFilter('rename',$file2name)
				->setAttrib('size', '11')
				->setDestination($path);

				$file3name = "ADDRESSPROOF3_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
				$file3 = new Zend_Form_Element_File('ADDR3');
				$file3->setLabel($this->getView()->translate('File3'))
				->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
				->addFilter('rename',$file3name)
				->setAttrib('size', '11')
				->setDestination($path);

			
 				$file3->setDecorators($decorator->openingFileDecorator);
  				$file2->setDecorators($decorator->openingFileDecorator);
  				$file1->setDecorators($decorator->openingFileDecorator);
				$addressproof->setDecorators($decorator->openingUlTagDecorator);
				$addressproofauthority->setDecorators($decorator->changeAddressProofAuthDecorator);
				$addressproofexpiry->setDecorators($decorator->changeAddressProofExpDecorator);
				$addressproofnumber->setDecorators($decorator->changeAddressProofNoDecorator);
				$addressproofother->setDecorators($decorator->changeAddressProofDecorator);
						
				$addressproofs->addElements(array($addressproof,$addressproofother,$addressproofnumber,$addressproofexpiry,$addressproofauthority,$file1,$file2,$file3));
						
				$addressproofs->setAttrib('enctype', 'multipart/form-data');

		return $addressproofs;
	}
}