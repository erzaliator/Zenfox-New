<?php
class Player_TransactionForm extends Zend_Form
{
	public function getCustomerForm($paymentMethod)
	{
		$amount = $this->createElement('text', 'amount');
		$amount->setLabel('Amount')
				->addValidator('Digits');
		
		//TODO setrequired for all the fields
		$firstName = $this->createElement('text', 'firstName');
		$firstName->setLabel('First Name*');
		
		$middleName = $this->createElement('text', 'middleName');
		$middleName->setLabel('Middle Name');
		
		$lastName = $this->createElement('text', 'lastName');
		$lastName->setLabel('Last Name');
		
		$address = $this->createElement('text', 'address');
		$address->setLabel('Address');
		
		$city = $this->createElement('text', 'city');
		$city->setLabel('City');
		
		$zip = $this->createElement('text', 'zip');
		$zip->setLabel('Pin Code');
		
		$countries = new Country();
		$countriesList = $countries->getAllCountriesList();
		$country = $this->createElement('select','country');
		$country->setLabel($this->getView()->translate('Country'));
		foreach($countriesList as $countryData)
		{
			$country->addMultiOption($countryData['country_code'], $countryData['country']);
		}
		
		$expMonth = $this->createElement('text', 'expMonth');
		$expMonth->setLabel('Expiration Month');
		
		$expYear = $this->createElement('text', 'expYear');
		$expYear->setLabel('Expiration Year');
		
		$cvc = $this->createElement('password', 'cvc');
		$cvc->setLabel('CVC No')
			->setRequired(true)
			->addValidator('Digits');
			
		$cardType = $this->createElement('select', 'cardType');
		$cardType->setLabel('Card Type')
				->addMultiOptions(array(
					'VISA' => 'Visa',
					'MASTER' => 'Master'));
		
		$submit = $this->getSubmitButton();
		
		$paymentType = $this->createElement('hidden', 'paymentType');
		$paymentType->setValue($paymentMethod);

		$this->addElements(array(
				$amount,
				$firstName,
				$middleName,
				$lastName,
				$address,
				$city,
				$zip,
				$country,
				$expMonth,
				$expYear,
				$cvc,
				$cardType,
				$submit,
				$paymentType,
			));
			
		//$this->setAction('/transaction/process');
		$this->setAttrib('id', 'player-gettransaction-form');
		return $this;
	}
	
	public function getPaymenttypeForm($playerData = NULL)
	{
		$decorator = new Zenfox_DecoratorForm();
		//TODO make subform
		//$paymentOptionForm = new Zend_Form_SubForm();
		/*$paymentType = $this->createElement('select', 'paymentType');
		$paymentType->setLabel('Select a payment type')
					->addMultioptions(array(
						'CREDIT' => 'Credit',
						'DEBIT' => 'Debit',
						'NETBANKING' => 'Net Banking'));
		*/
		$paymentType = $this->createElement('radio', 'paymentType');
/*		$paymentType->setLabel('Payment Type')
				->addMultiOptions(array(
					'NETBANKING' => 'Netbanking',
					'CASH' => 'Cash On Delivery',
					'DEBIT' => 'Debit Card',
					'CREDIT' => 'Credit Card'
				))
			->setOptions(array('onclick' => 'displayList()'));*/

		if(($playerData['player_id'] == 2130) || ($playerData['player_id'] == 52))
		{
			$paymentType->setLabel('Payment Type')
                                ->addMultiOptions(array(
                                        'NETBANKING' => 'Netbanking',
                                        'CASH' => 'Cash On Delivery',
                                        'DEBIT' => 'Debit Card',
                                        'CREDIT' => 'Credit Card',
					'MOL' => 'MOL',
                                ))
                        ->setOptions(array('onclick' => 'displayList()'));
		}
		else
		{
			$paymentType->setLabel('Payment Type')
                                ->addMultiOptions(array(
                                        'NETBANKING' => 'Netbanking',
                                        'CASH' => 'Cash On Delivery',
                                        'DEBIT' => 'Debit Card',
                                        'CREDIT' => 'Credit Card'
                                ))
                        ->setOptions(array('onclick' => 'displayList()'));
		}
		
	
		 $bankList = $this->createElement('select', 'bankCode');
         $bankList->setLabel('Select A Bank')
         		->setAttrib('id', 'bankList')
                 ->addMultiOptions(array(
                     '10' => 'ICICI Bank',
                     '50' => 'Axis Bank',
                     '120' => 'Corporation Bank',
                     '130' => 'Yes Bank',
                     '140' => 'Karnataka Bank',
                     '160' => 'Oriental Bank of Commerce',
                     '240' => 'Bank of India',
                     '170' => 'Bank of Rajasthan',
                     '180' => 'South Indian Bank',
                     '200' => 'Vijaya Bank',
                     '270' => 'Federal Bank',
                     '310' => 'Bank of Baroda',
                    '340' => 'Bank of Bahrain and Kuwait',
                     '370' => 'Dhanlaxmi Bank',
                    '330' => 'Deutsche Bank',
                     '190' => 'Union Bank of India',
                     '450' => 'Standard Chartered Bank',
                     '420' => 'Indian Overseas Bank',
                     '280' => 'Allahabad Bank',
                     '300' => 'HDFC Bank',
                     '230' => 'Citi Bank',
                     '520' => 'IDBI Bank',
                     '530' => 'State Bank of India',
                     '440' => 'City Union Bank',
                     '550' => 'State Bank of Mysore',
                     '560' => 'State Bank of Hyderabad',
                     '490' => 'Indian Bank',
                     '620' => 'Tamilnad Mercantile Bank',
                     '540' => 'Development Credit Bank',
             ));
         
        $cityList = $this->createElement('select', 'city');
        $cityList->setLabel('Select City');
	$cityList->addMultiOptions(array(
        			"Hyderabad" => "Hyderabad",
        			"Chennai" => "Chennai",
        			"Mumbai" => "Mumbai",
        			"Navi Mumbai" => "Navi Mumbai",
        			"Thane" => "Thane",
        			"Bangalore" => "Bangalore",
        			"Pune" => "Pune",
        			"New Delhi" => "New Delhi",
        			"Ghaziabad" => "Ghaziabad",
        			"Noida" => "Noida",
        			"Gurgaon" => "Gurgaon",
        			"Visakhapatnam" => "Visakhapatnam",
        			"DELHI" => "Delhi",
        			"Faridabad" => "Faridabad",
        			"Kolkata" => "Kolkata",
        			"Chandigarh" => "Chandigarh",
        		))
		->setValue($playerData['city']);
/*        if($cities)
        {
        	foreach($cities as $cityName)
        	{
        		$cityList->addMultiOption($cityName, $cityName);
        	}
        }
*/
	$loginName = $playerData['login'];
        $firstName = $playerData['first_name'];
        
        $player_name = empty($firstName)?$loginName:$firstName;

	$playerName = $this->createElement('text', 'playerName');
        $playerName->setLabel('Name')
		->setValue($player_name);
        
        $playerContactNo = $this->createElement('text', 'playerContactNo');
        $playerContactNo->setLabel('Contact No')
			->setValue($playerData['phone']);
        
        $emailAddress = $this->createElement('text', 'emailAddress');
        $emailAddress->setLabel('Email')
		->setValue($playerData['email']);

		$amount = $this->createElement('radio', 'amount');
		$amount->setLabel('Select Amount*')
			->addMultiOptions(array(
					'100' => '100 Rs',
					'200' => '200 Rs',
					'500' => '500 Rs',
					'1000' => '1000 Rs',
					'2000' => '2000 Rs',
					'custom' => 'Custom Rs'
				))
			->setRequired(true)
			->setValue(100)
			//->setSeparator('')
			->setOptions(array('onclick' => 'displayCustomField()'));
			//->setAttrib('id', 'checkBox');

		$customAmount = $this->createElement('text', 'customAmt');
		//$customAmount->setOptions(array('onclick' => 'disableCustomField()'));

		$coupon = $this->createElement('text', 'couponCode');
		$coupon->setLabel('Enter Coupon Code');
		
		$this->addElements(array(
				$amount,
				$paymentType,
				$bankList,
				$cityList,
				$playerName,
				$playerContactNo,
				$emailAddress,
				$customAmount,
				$coupon,
			));
		
		 $this->addElement(
		    	'textarea',
		    	'address',
				array(
					'label' => $this->getView()->translate('Address'),
					'style' => 'width: 18em; height: 5em; line-height: 12px;',
					'class' => 'text',
					'decorators' => $decorator->changeAddressDecorator,
					'value' => $playerData['address'],
					//'required' => true,
				)
			); 
		$contactNo = $this->createElement('text', 'contact');
		$contactNo->setLabel('Contact No')
			->setValue($playerData['phone']);
			//->setRequired(true);
		
		$pin = $this->createElement('text','pin');
		$pin->setLabel($this->getView()->translate('Pin Code'))
			->addValidator('Digits')
			//->setRequired(true)
			->setAttrib('id', 'pinCode')
			->setValue($playerData['pin']);
			//->setAttrib('class', 'text');
		
		
		//$paymentOptionForm->addElement($paymentType);
		//$this->addSubForm($paymentOptionForm, 'paymentType');
		$submit = $this->getSubmitButton();
		
		$this->addElements(array(
				$contactNo,
				$pin,
				$submit,
			));
	
		$controller = $this->createElement('hidden', 'controller');
		$controller->setValue('banking');
		$this->addElement($controller);
		
		//$this->setAction('https://taashtime.com/transaction/index');	
		//$this->setAction('/transaction/process');
		$this->setAttrib('id', 'player-getpayment-form');
		$amount->setDecorators($decorator->openingCheckBoxDecorator);
		$paymentType->setDecorators($decorator->paymentCheckBoxDecorator);
		$bankList->setDecorators($decorator->changeBankUlTagDecorator);
		$cityList->setDecorators($decorator->changeCityUlTagDecorator);
		$playerName->setDecorators($decorator->changeNameUlTagDecorator);
		$playerContactNo->setDecorators($decorator->changePlayerContactUlTagDecorator);
		$emailAddress->setDecorators($decorator->changeEmailUlTagDecorator);
		$contactNo->setDecorators($decorator->changeContactDecorator);
		$pin->setDecorators($decorator->changePinCodeDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		$customAmount->setDecorators($decorator->closingCheckBoxDecorator);
		$coupon->setDecorators($decorator->changeCouponDecorator);
		return $this;
	}
	
	public function getSubmitButton()
	{
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');
		//$this->addElement($submit);
		return $submit;
	}

	public function getTransactionForm($playerAmount, $code, $playerId)
	{
		/*$srcSiteId = $this->createElement('hidden', 'SRCSITEID');
		$srcSiteId->setValue('T1472');
		
		$crn = $this->createElement('hidden', 'CRN');
		$crn->setValue('INR');

		$amt = $this->createElement('hidden', 'AMT');
		$amt->setLabel('Amount - ' . $amount)
			->setValue($amount);

		$itc = $this->createElement('hidden', 'ITC');
		$itc->setValue(4);

		$prn = $this->createElement('hidden', 'PRN');
		$prn->setValue(8);

		$confirm = $this->createElement('submit', 'confirm');
		$confirm->setLabel('Confirm')
			->setIgnore(true);

		$front = Zend_Controller_Front::getInstance()->getRequest();
		$language = $front->getParam('lang');
		if($language)
		{
			$dpLink = '/' . $language . '/banking/deposit';
		}
		else
		{
			$dpLink = '/banking/deposit';
		}
		$backLink = '<a href = "' . $dpLink . '">' . $this->getView()->translate('Go Back') . '</a>';
				
		$notConfirm = $this->createElement('hidden', 'notConfirm');
		$notConfirm->setDescription($backLink);

		$this->addElements(array(
				$srcSiteId,
				$crn,
				$amt,
				$itc,
				$prn,
				$confirm,
				$notConfirm
			));

		$this->setAction('https://www.tpsl-india.in/PaymentGateway/GatewayEnter.jsp');
		$decorator = new Zenfox_DecoratorForm();
		$notConfirm->setDecorators($decorator->linkDecorator);*/

		$playerTransaction = new PlayerTransactionRecord();
		$transactionId = $playerTransaction->getTransactionId($playerId);
		$transId = $this->createElement('hidden', 'txtTranID');
		$transId->setValue($transactionId);
		
		$marketCode = $this->createElement('hidden', 'txtMarketCode');
		//$marketCode->setValue('T1472');
		//$marketCode->setValue('L1472');
		$marketCode->setValue('L2636');

		$accountNumber = $this->createElement('hidden', 'txtAcctNo');
		$accountNumber->setValue('1');

		$amount = $this->createElement('hidden', 'txtTxnAmount');
		$amount->setLabel('Amount - Rs ' . $playerAmount)
			->setValue($playerAmount);

		$bankCode = $this->createElement('hidden', 'txtBankCode');
		$bankCode->setValue($code);

		$propertyFile = $this->createElement('hidden', 'txtPropPath');
		$propertyFile->setValue(APPLICATION_PATH . '/../public/MerchantDetails.properties');

		$confirm = $this->createElement('submit', 'confirm');
		$confirm->setLabel('Make Payment')
			->setIgnore(true)
			->setAttrib('id', 'submit');

		$notConfirm = $this->createElement('submit', 'notConfirm');
		$notConfirm->setLabel('Cancel')
				->setIgnore(true)
				->setAttrib('id', 'submit');

		$this->addElements(array(
				$transId,
				$marketCode,
				$accountNumber,
				$amount,
				$bankCode,
				$propertyFile,
				$notConfirm,
				$confirm,
			));
		
		$this->setAttrib('id', 'payment-form');
			
		$decorator = new Zenfox_DecoratorForm();
		$transId->setDecorators($decorator->openingUlTagDecorator);
		$marketCode->setDecorators($decorator->changeUlTagDecorator);
		$accountNumber->setDecorators($decorator->changeUlTagDecorator);
		$amount->setDecorators($decorator->changeUlTagDecorator);
		$bankCode->setDecorators($decorator->changeUlTagDecorator);
		$propertyFile->setDecorators($decorator->changeUlTagDecorator);
		$notConfirm->setDecorators($decorator->changeUlButtonTagDecorator);
		$confirm->setDecorators($decorator->closingUlButtonTagDecorator);
		return $this;
	}
	
	public function getAddressForm($playerAmount, $playerAddress, $playerCity, $playerPinCode, $playerContact, $playerId)
	{
		$playerTransaction = new PlayerTransactionRecord();
		$transactionId = $playerTransaction->getTransactionId($playerId);
		$transId = $this->createElement('hidden', 'transId');
		$transId->setValue($transactionId);
		
		$amount = $this->createElement('hidden', 'amount');
		$amount->setLabel('Amount - Rs ' . $playerAmount)
				->setValue($playerAmount);
		
		$address = $this->createElement('hidden', 'address');
		$address->setLabel('Address : ' . $playerAddress)
				->setValue($playerAddress);
		
		$city = $this->createElement('hidden', 'city');
		$city->setLabel('City : ' . $playerCity)
			->setValue($playerCity);
		
		$pin = $this->createElement('hidden', 'pin');
		$pin->setLabel('Pin : ' . $playerPinCode)
			->setValue($playerPinCode);
		
		$contact = $this->createElement('hidden', 'contact');
		$contact->setLabel('Contact : ' . $playerContact)
				->setValue($playerContact);		
		
		$confirm = $this->createElement('submit', 'confirm');
		$confirm->setLabel('Make Payment')
				->setIgnore(true)
				->setAttrib('id', 'submit');
		
		$notConfirm = $this->createElement('submit', 'notConfirm');
		$notConfirm->setLabel('Cancel')
				->setIgnore(true)
				->setAttrib('id', 'submit');
		
		$this->addElements(array(
				$transId,
				$amount,
				$address,
				$city,
				$pin,
				$contact,
				$confirm,
				$notConfirm
		));
		$this->setAttrib('id', 'payment-form');
		return $this;
		
		//$decorator = new Zenfox_DecoratorForm();
		
	}

	public function getEssecomForm($transAmount, $playerName, $playerContact, $playerEmail, $playerId)
	{
		$playerTransaction = new PlayerTransactionRecord();
		$transactionId = $playerTransaction->getTransactionId($playerId);
		
		$name = $this->createElement('hidden', 'Name');
		$name->setLabel('Name : ' . $playerName)
			->setValue($playerName);
		
		$contact = $this->createElement('hidden', 'ContactNo');
		$contact->setLabel('Contact : ' . $playerContact)
			->setValue($playerContact);
		
		$email = $this->createElement('hidden', 'Email');
		$email->setLabel('Email : ' . $playerEmail)
			->setValue($playerEmail);
		
		$amount = $this->createElement('hidden', 'Amount');
		$amount->setLabel('Amout : Rs. ' . $transAmount)
			->setValue($transAmount);
		
		$inrAmount = $this->createElement('hidden', 'INRAmount');
		$inrAmount->setValue($transAmount);
		
		$merchantId = $this->createElement('hidden', 'MerchantId');
		$merchantId->setValue("ESSFORT001");
		
		//$transactionId = 1;
		
		/* $radno = rand(1111111111, 9999999999);
		$radno1 = rand(1111111111, 9999999999);
		$transactionId = $radno.$radno1; */
		
		$referenceNo = $this->createElement('hidden', 'ReferenceNo');
		$referenceNo->setValue($transactionId);
		
		$hash = hash('sha256', "ESSFORT001|" . $transAmount . "|" . $transAmount . "|". $transactionId);
		$checkSum = $this->createElement('hidden', 'CheckSum');
		$checkSum->setValue($hash);
		
		$password = $this->createElement('hidden', 'Password');
		$password->setValue('mn69hg0j');
		
		$currencyCode = $this->createElement('hidden', 'CurrencyCode');
		$currencyCode->setValue(356);
		
		$ip = "182.18.148.197";
		
		$clientIP = $this->createElement('hidden', 'RemoteIP');
		$clientIP->setValue($ip);
		
		$confirm = $this->createElement('submit', 'confirm');
		$confirm->setLabel('Make Payment')
				->setIgnore(true)
				->setAttrib('id', 'submit');
		
		/* $notConfirm = $this->createElement('text', 'notConfirm');
		$notConfirm->setLabel('Cancel')
				->setIgnore(true)
				->setAttrib('id', 'submit')
				->setOptions(array('onclick' => 'goToBankPage()')); */
		
		$notConfirmDescription = '<a href = "#" onClick="goToBankPage()"><img src="/css/rummy.tld/images/cancel.jpg" width="130px" height="45px"/></a>';
		$notConfirm = $this->createElement('hidden', 'notConfirm');
		$notConfirm->setDescription($notConfirmDescription);
		
		
		$this->addElements(array(
				$name,
				$contact,
				$email,
				$amount,
				$notConfirm,
				$confirm,
				$inrAmount,
				$merchantId,
				$referenceNo,
				$checkSum,
				$password,
				$currencyCode,
				$clientIP,
			));
		
		$this->setAttrib('id', 'payment-form');
		//$this->setAction("https://cellpay.essecom.com/PaymentGateway/Payment.jsp");
		$this->setAction("https://payment.essecom.com/PaymentGateway/Payment.jsp");
		
		$decorator = new Zenfox_DecoratorForm();
		$name->setDecorators($decorator->openingUlTagDecorator);
		$contact->setDecorators($decorator->changeUlTagDecorator);
		$email->setDecorators($decorator->changeUlTagDecorator);
		$amount->setDecorators($decorator->changeUlTagDecorator);
		$notConfirm->setDecorators($decorator->facebookLinkDecorator);
		/* $bankCode->setDecorators($decorator->changeUlTagDecorator);
		$propertyFile->setDecorators($decorator->changeUlTagDecorator);
		$notConfirm->setDecorators($decorator->changeUlButtonTagDecorator); */
		$confirm->setDecorators($decorator->closingUlButtonTagDecorator);
		return $this;
	}

	public function getMolForm($transAmount, $playerId)
	{
		$playerTransaction = new PlayerTransactionRecord();
		$transactionId = $playerTransaction->getTransactionId($playerId);
		
		$amount = $this->createElement('hidden', 'amount');
		$amount->setLabel('Amount : ' . $transAmount)
			->setValue($transAmount);
		
		$transId = $this->createElement('hidden', 'transId');
		$transId->setValue($transactionId);
		
		$confirm = $this->createElement('submit', 'confirm');
		$confirm->setLabel('Make Payment')
			->setIgnore(true)
			->setAttrib('id', 'submit');
		
		$notConfirm = $this->createElement('submit', 'notConfirm');
		$notConfirm->setLabel('Cancel')
			->setIgnore(true)
			->setAttrib('id', 'submit');
		
		$this->addElements(array(
				$amount,
				$transId,
				$notConfirm,
				$confirm
			));
		
		$this->setAttrib('id', 'payment-form');
		$decorator = new Zenfox_DecoratorForm();
		$amount->setDecorators($decorator->openingUlTagDecorator);
		$notConfirm->setDecorators($decorator->changeUlButtonTagDecorator);
		$confirm->setDecorators($decorator->closingUlButtonTagDecorator);
		
		return $this;
	}

	public function getEBSForm($transAmount, $playerName, $playerPhone, $playerEmail, $playerId, $playerAddress, $playerCity, $playerState, $postalCode)
        {
                $playerTransaction = new PlayerTransactionRecord();
                $transactionId = $playerTransaction->getTransactionId($playerId);

                $name = $this->createElement('hidden', 'name');
                $name->setLabel('Name : ' . $playerName)
                        ->setValue($playerName);

                $address = $this->createElement('hidden', 'address');
                $address->setLabel('Address : ' . $playerAddress)
                        ->setValue($playerAddress);

                $city = $this->createElement('hidden', 'city');
                $city->setLabel('City : ' . $playerCity)
                        ->setValue($playerCity);

                $state = $this->createElement('hidden', 'state');
                $state->setLabel('State : ' . $playerState)
                        ->setValue($playerState);

                $pin = $this->createElement('hidden', 'postalCode');
                $pin->setLabel('PinCode : ' . $postalCode)
                        ->setValue($postalCode);

                $phone = $this->createElement('hidden', 'phone');
                $phone->setLabel('Contact : ' . $playerPhone)
                        ->setValue($playerPhone);

                $email = $this->createElement('hidden', 'email');
                $email->setLabel('Email : ' . $playerEmail)
                        ->setValue($playerEmail);

                $amount = $this->createElement('hidden', 'amount');
                $amount->setLabel('Amout : Rs. ' . $transAmount)
			->setValue($transAmount);

                $transId = $this->createElement('hidden', 'transId');
                $transId->setValue($transactionId);

                $confirm = $this->createElement('submit', 'confirm');
                $confirm->setLabel('Make Payment')
                                ->setIgnore(true)
                                ->setAttrib('id', 'submit');

                $notConfirmDescription = '<a href = "#" onClick="goToBankPage()"><img src="/css/rummy.tld/images/cancel.jpg" width="130px" height="45px"/></a>';
                $notConfirm = $this->createElement('hidden', 'notConfirm');
                $notConfirm->setDescription($notConfirmDescription);

                $this->addElements(array(
                                $name,
                                $address,
                                $city,
                                $state,
                                $pin,
                                $phone,
                                $email,
                                $amount,
                                $notConfirm,
                                $confirm,
                                $transId,
                        ));

                //$this->setAction("https://cellpay.essecom.com/PaymentGateway/Payment.jsp");
                $this->setAction("http://www.dailyhomeshop.com/order");

                $decorator = new Zenfox_DecoratorForm();
                $name->setDecorators($decorator->openingUlTagDecorator);
                $address->setDecorators($decorator->changeUlTagDecorator);
                $city->setDecorators($decorator->changeUlTagDecorator);
                $state->setDecorators($decorator->changeUlTagDecorator);
		$pin->setDecorators($decorator->changeUlTagDecorator);
                $phone->setDecorators($decorator->changeUlTagDecorator);
                $email->setDecorators($decorator->changeUlTagDecorator);
                $amount->setDecorators($decorator->changeUlTagDecorator);
                $notConfirm->setDecorators($decorator->facebookLinkDecorator);
                $confirm->setDecorators($decorator->closingUlButtonTagDecorator);
                return $this;
	}
	
	public function getDirecPayForm($transAmount, $playerName, $playerPhone, $playerEmail, $playerId, $playerAddress, $playerCity, $playerState, $postalCode)
	{
		$playerTransaction = new PlayerTransactionRecord();
		$transactionId = $playerTransaction->getTransactionId($playerId);
		
		$phoneNoArray = array(1,2,3,4,5,6,7,8,9);
		$phoneNo = "";
		for($i = 0; $i < 8; $i++)
		{
			$phoneNo .= mt_rand(0, count($phoneNoArray) - 1);
		}
		
		$request = '200904281000001|DOM|IND|INR|' . $transAmount . '|' . $transactionId . '|Testing|https://taashtime.com/transaction/confirm|https://taashtime.com/transaction/confirm|TOML';
		$billing = $playerName . '|' . $playerAddress . '|' . $playerCity . '|' . $playerState . '|' . $postalCode . '|IN|91|040|' . $phoneNo . '|' . $playerPhone . '|' . $playerEmail . '|Testing';
		$delivery = $billing = $playerName . '|' . $playerAddress . '|' . $playerCity . '|' . $playerState . '|' . $postalCode . '|IN|91|040|' . $phoneNo . '|' . $playerPhone . '|' . $playerEmail;
		$key = "qcAHa6tt8s0l5NN7UWPVAQ==";

		$aes = new AES($key);
		
		$request = $aes->fnEncrypt($request, $key);
		$request.str_replace("\n", "", $request);
		
		$billing = $aes->fnEncrypt($billing, $key);
		$billing.str_replace("\n", "", $billing);
		
		$delivery = $aes->fnEncrypt($delivery, $key);
		$delivery.str_replace("\n", "", $delivery);
		
	
		$requestParam = $this->createElement('hidden', 'requestparameter');
		$requestParam->setValue($request);
		
		$billingDetails = $this->createElement('hidden', 'billingDtls');
		$billingDetails->setValue($billing);
		
		$shippingDetails = $this->createElement('hidden', 'shippingDtls');
		$shippingDetails->setValue($delivery);
		
		$merchantId = $this->createElement('hidden', 'merchantId');
		$merchantId->setValue('200904281000001');
	
		$confirm = $this->createElement('submit', 'confirm');
		$confirm->setLabel('Make Payment')
				->setIgnore(true)
				->setAttrib('id', 'submit');
	
		$notConfirmDescription = '<a href = "#" onClick="goToBankPage()"><img src="/css/rummy.tld/images/cancel.jpg" width="130px" height="45px"/></a>';
		$notConfirm = $this->createElement('hidden', 'notConfirm');
		$notConfirm->setDescription($notConfirmDescription);
	
		$this->addElements(array(
				$requestParam,
				$billingDetails,
				$shippingDetails,
				$merchantId,
				$notConfirm,
				$confirm,
			));
	
		$this->setAction("https://test.direcpay.com/direcpay/secure/dpMerchantPayment.jsp");
	
		$decorator = new Zenfox_DecoratorForm();
		$requestParam->setDecorators($decorator->openingUlTagDecorator);
		$billingDetails->setDecorators($decorator->changeUlTagDecorator);
		$shippingDetails->setDecorators($decorator->changeUlTagDecorator);
		$merchantId->setDecorators($decorator->changeUlTagDecorator);
		$notConfirm->setDecorators($decorator->facebookLinkDecorator);
		$confirm->setDecorators($decorator->closingUlButtonTagDecorator);
		return $this;
	}
}
