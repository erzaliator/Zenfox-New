<?php
class Admin_UpdateVerificationForm extends Zend_Form
{
	public function getform($data = null)
	{
		
		$this->setAction('/withdrawal/addverified');
		$decorator = new Zenfox_DecoratorForm();
		
		$path = Zend_Registry::getInstance()->get('UploadDocumentPath');
		
		$today = new Zend_Date();
		$currentTime = $today->get(Zend_Date::W3C);
		
		$playerid = $this->createElement('text','playerid');
		$playerid->setLabel($this->getView()->translate('playerid * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['playerid'])
		->addvalidator('Digits')
		->setRequired(true);
		
		$firstname = $this->createElement('text','first_name');
		$firstname->setLabel($this->getView()->translate('First Name * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['first_name'])
		->addValidator(new Zenfox_Validate_UsernameValidator)
		->setRequired(true);
		
		$lastname = $this->createElement('text','last_name');
		$lastname->setLabel($this->getView()->translate('Last Name * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['last_name'])
		->addValidator(new Zenfox_Validate_UsernameValidator)
		->setRequired(true);
		
		$sex = new Zend_Form_Element_Select('sex');
		$sex->setLabel('Sex *')
		->setMultiOptions(array('male'=>'MALE', 'female'=>'FEMALE'))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['sex'])
		->setRequired(true);
		
		
		
		$dob =new ZendX_JQuery_Form_Element_DatePicker('dateofbirth',
				array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		$dob->setLabel('Date Of Birth *')
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['dateofbirth'])
		->setRequired(true);
		
		$address =new Zend_Form_Element_Textarea('address');
		$address->setLabel($this->getView()->translate('Address * '))
		->setAttrib('rows','5')
		->setAttrib('cols','10')
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['address'])
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true) ;
		
		$city = $this->createElement('text','city');
		$city->setLabel($this->getView()->translate('City * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['city'])
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		
		$countries = new Country();
		$countriesList = $countries->getAllCountriesList();
		$country = $this->createElement('select','country');
		$country->setLabel($this->getView()->translate('Country'))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['country'])
		->setRequired(true);
		foreach($countriesList as $countryData)
		{
			$country->addMultiOption($countryData['country_code'], $countryData['country']);
		}
		
		$state = $this->createElement('text','state');
		$state->setLabel($this->getView()->translate('State * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['state'])
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		
		
		$pincode = $this->createElement('text','pin');
		$pincode->setLabel($this->getView()->translate('Pincode * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['pin'])
		->addvalidator('Digits')
		->setRequired(true);
		
		$email = $this->createElement('text',"email");
		$email->setLabel($this->getView()->translate('Email * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->addValidator('emailAddress', false, array(6,50,'messages' => array('emailAddressInvalidFormat' => $this->getView()->translate("Email Address should be in format username@hostname"))))
		->setValue($data['email'])
		->setRequired(true);
		
		$phone = $this->createElement('text','phone');
		$phone->setLabel($this->getView()->translate('phone * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['phone'])
		->addvalidator('Digits')
		->setRequired(true);
		
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
		
			
		$idfile1name = "IDPROOF1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
		$idfile1 = new Zend_Form_Element_File('ID1');
		$idfile1->setLabel($this->getView()->translate('ID PROOF 1 *'))
		->setRequired(true)
		->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
		->addFilter('rename',$idfile1name)
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setDestination($path);
			
		$idfile2name = "IDPROOF2_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
		$idfile2 = new Zend_Form_Element_File('ID2');
		$idfile2->setLabel($this->getView()->translate('ID PROOF 2'))
		->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
		->addFilter('rename',$idfile2name)
		->setDestination($path);
		
		$idfile3name = "IDPROOF3_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
		$idfile3 = new Zend_Form_Element_File('ID3');
		$idfile3->setLabel($this->getView()->translate('ID PROOF 3'))
		->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
		->addFilter('rename',$idfile3name)
		->setDestination($path);
		
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
		
		$addrfile1name = "ADDRESSPROOF1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
		$addrfile1 = new Zend_Form_Element_File('ADDR1');
		$addrfile1->setLabel($this->getView()->translate('File1 *'))
		->setRequired(true)
		->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->addFilter('rename',$addrfile1name)
		->setAttrib('size', '11')
		->setDestination($path);
			
		$addrfile2name = "ADDRESSPROOF2_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
		$addrfile2 = new Zend_Form_Element_File('ADDR2');
		$addrfile2->setLabel($this->getView()->translate('File2'))
		->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
		->addFilter('rename',$addrfile2name)
		->setAttrib('size', '11')
		->setDestination($path);
		
		$addrfile3name = "ADDRESSPROOF3_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"])."_".$currentTime.".jpg";
		$addrfile3 = new Zend_Form_Element_File('ADDR3');
		$addrfile3->setLabel($this->getView()->translate('File3'))
		->addValidator('ExcludeExtension', false, array('php', 'exe', 'case', 'jar' , 'out', 'deb' , 'py',"ade", "adp", "bat", "chm", "cmd", "com", "cpl","hta", "ins", "isp", "jse", "lib", "mde", "msc", "msp","mst", "pif", "scr", "sct", "shb", "sys", "vb", "vbe","vbs", "vxd", "wsc", "wsf", "wsh" => true))
		->addFilter('rename',$addrfile3name)
		->setAttrib('size', '11')
		->setDestination($path);
		
		
		$NAME = $this->createElement('text','name as on bank');
		$NAME->setLabel($this->getView()->translate('NAME(As on Bank Account) * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value required'))
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		
		$Bank = $this->createElement('text','bank');
		$Bank->setLabel($this->getView()->translate('BANK NAME * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value required'))
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		
		$BankAccountNo = $this->createElement('text','BankAccountNumber');
		$BankAccountNo->setLabel($this->getView()->translate('Bank Account Number * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value required'))
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		
		$BankAccountNoRe = $this->createElement('text','BankAccountNumberRe');
		$BankAccountNoRe->setLabel($this->getView()->translate('Re-type Bank Account Number * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value required'))
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		
		$Branch = $this->createElement('text','Branch');
		$Branch->setLabel($this->getView()->translate('Branch * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value required'))
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		
		$IFSCCode = $this->createElement('text','ifsccode');
		$IFSCCode->setLabel($this->getView()->translate('IFSC Code * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value required'))
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Insert');

		$this->addElements(array($playerid,$firstname, $lastname, $sex,$dob,$address,$city,$state,$country,$pincode,$email,$phone,$idproof,$idproofother,
				$idproofnumber,$idproofauthority,$idproofexpiry,$idfile1,$idfile2,$idfile3,$addressproof,$addressproof,$addressproofother,
				$addressproofnumber,$addressproofauthority,$addressproofexpiry,$addrfile1,$addrfile2,$addrfile3,
				$NAME,$Bank,$BankAccountNo,$BankAccountNoRe,$Branch,$IFSCCode,$submit));

		$this->setAttrib('enctype', 'multipart/form-data');
		
		$playerid->setDecorators($decorator->changeWithdrawalUlTagDecorator);
		$firstname->setDecorators($decorator->changeWithdrawalUlTagDecorator);
		$lastname->setDecorators($decorator->changeWithdrawalLiTagDecorator);
		$email->setDecorators($decorator->changeWithdrawalLiTagDecorator);
		$pincode->setDecorators($decorator->changeWithdrawalLiTagDecorator);
		$phone->setDecorators($decorator->changeClearUlTagDecorator);
		$city->setDecorators($decorator->changeWithdrawalLiTagDecorator);
		$state->setDecorators($decorator->changeWithdrawalLiTagDecorator);
		$country->setDecorators($decorator->changeWithdrawalUlTagDecorator);
		$address->setDecorators($decorator->changeClearUlTagDecorator);
		$dob->setDecorators($decorator->formJQueryElements);
		$sex->setDecorators($decorator->changeWithdrawalUlTagDecorator);
		
		$idfile1->setDecorators($decorator->openingFileDecorator);
		$idfile2->setDecorators($decorator->openingFileDecorator);
		$idfile3->setDecorators($decorator->openingFileDecorator);
		$idproof->setDecorators($decorator->openingUlTagDecorator);
		$idproofother->setDecorators($decorator->changeIdProofDecorator);
		$idproofauthority->setDecorators($decorator->changeIdProofAuthDecorator);
		$idproofexpiry->setDecorators($decorator->changeIdProofExpDecorator);
		$idproofnumber->setDecorators($decorator->changeIdProofNoDecorator);
		
		$addrfile1->setDecorators($decorator->openingFileDecorator);
		$addrfile2->setDecorators($decorator->openingFileDecorator);
		$addrfile3->setDecorators($decorator->openingFileDecorator);
		$addressproof->setDecorators($decorator->openingUlTagDecorator);
		$addressproofauthority->setDecorators($decorator->changeAddressProofAuthDecorator);
		$addressproofexpiry->setDecorators($decorator->changeAddressProofExpDecorator);
		$addressproofnumber->setDecorators($decorator->changeAddressProofNoDecorator);
		$addressproofother->setDecorators($decorator->changeAddressProofDecorator);
		
		$NAME->setDecorators($decorator->openingUlTagDecorator);
		$IFSCCode->setDecorators($decorator->closingUlTagDecorator);
		$Branch->setDecorators($decorator->changeUlTagDecorator);
		$BankAccountNoRe->setDecorators($decorator->changeUlTagDecorator);
		$BankAccountNo->setDecorators($decorator->changeUlTagDecorator);
		$Bank->setDecorators($decorator->changeUlTagDecorator);
		
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
		return $this;
	}
}