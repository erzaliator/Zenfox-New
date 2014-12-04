<?php
class Admin_BingoForm extends Zend_Form
{
	public function getForm()
	{
		$bingo = new Zend_Form_SubForm();
		Zend_Dojo::enableForm($bingo);
		
		$bingoGameId = $bingo->createElement('hidden', 'bingoGameId');
		$bingo->addElement($bingoGameId);
		
		$name = $bingo->createElement('text', 'name');
		$name->setLabel('Game Name *')
			->setRequired(true)
			->setAttrib("id","game_name");
		$bingo->addElement($name);
		
		$bingo->addElement(
					'SimpleTextarea',
					'description',
					array(
							'label' => 'Description',
							'style' => 'width: 30em; height: 10em;'
						 )
					);
					
		$flavour = new Flavour();
		$flavourData = $flavour->getFlavourData();
		$gameFlavour = $bingo->createElement('select', 'gameFlavour');
		$gameFlavour->setLabel('Game Flavour *')
					->setRequired(true)
					->addMultiOptions(array(
								'90' => '90 Ball',
								'SW' => 'SW Ball',
								'75' => '75 Ball',
								'80' => '80 Ball'));
		
		$gameType = $bingo->createElement('select', 'gameType');
		$gameType->setLabel('Game Type *')
				->setRequired(true)
				->addMultiOption('VARIABLE', 'Variable')
				->addMultiOption('FIXED', 'Fixed');
				
				
		$categoryobj = new BingoCategory();
		$allcategories = $categoryobj->getAllCategories();
				//Zenfox_Debug::dump($allcategories);exit;
        $category = $bingo->createElement('multiCheckbox', 'category');
        $category->setLabel($this->getView()->translate('Category'));
        
        foreach($allcategories as $data)
        {
        	 $category->addMultiOption($data["id"],$data["name"]);
        }
      	$category->setSeparator(' ')
      			->setValue(array(1));
		
		$amountType = $bingo->createElement('radio', 'amountType');
		$amountType->setLabel('Amount Type *')
				->setRequired(true)
				->addMultiOptions(array(
								'REAL' => 'Real',
								'BBS' => 'Bonus',
								'BOTH' => 'Both'));

		$potType = $bingo->createElement('select', 'potType');
		$potType->setLabel('Pot Type')
				->addMultiOption('SEPARATE', 'Separate')
				->addMultiOption('COMBINED', 'Combined');
				
		$pattern = new BingoPattern();
		$allPatternsData = $pattern->getAllPatternsData();
		$pattern = $bingo->createElement('select', 'pattern');
		$pattern->setLabel('Pattern Name *')
				->setRequired(true);
		foreach($allPatternsData as $patternData)
		{
			$pattern->addMultiOption($patternData['id'], $patternData['name']);
		}
		
		//TODO Get the no of parts for selected pattern.
		$noOfParts = $bingo->createElement('text', 'noOfParts');
		$noOfParts->setLabel('No Of Parts *')
				->setRequired(true);
		
		$cardPrice = $bingo->createElement('text', 'cardPrice');
		$cardPrice->setLabel('Card Price *')
				->setRequired(true);
				
		$minCards = $bingo->createElement('text', 'minCards');
		$minCards->setLabel('Minimum Cards *')
				->setRequired(true)
				->addValidator('Digits');
				
		$maxCards = $bingo->createElement('text', 'maxCards');
		$maxCards->setLabel('Maximum Cards *')
				->setRequired(true)
				->addValidator('Digits');
				
		$freeRatio = $bingo->createElement('text', 'freeRatio');
		$freeRatio->setLabel('Free Ratio (bought:free)*')
				->setRequired(true);
				
		//TODO save the time in seconds

		$buyTime = $bingo->createElement('text', 'buyTime');
		$buyTime->setLabel('Buy Time (in sec)*')
				->setRequired(true);
				
		$callDelay = $bingo->createElement('text', 'callDelay');
		$callDelay->setLabel('Call Delay (in sec)*')
				->setRequired(true);
		
		$pjpEnabled = $bingo->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel('Pjp Enabled')
				->setCheckedValue('ENABLED')
				->setUncheckedValue('DISABLED');

		$pjpobj = new Pjp();
		$pjpdetails = $pjpobj->getPjpDetails();
		$pjp = $bingo->createElement('select', 'pjp');
		$pjp->setLabel('PJP Name *');
		foreach($pjpdetails as $pjpdata)
		{
			$pjp->addMultiOption($pjpdata['id'] , $pjpdata['pjp_name']);
		}
		
		$pjppercentReal = $bingo->createElement('text', 'pjppercentReal');
		$pjppercentReal->setLabel('PJP Percent Real ');
				
		$pjppercentBbs = $bingo->createElement('text', 'pjppercentBbs');
		$pjppercentBbs->setLabel('PJP Percent Bonus ');
		
		$pjpmax_no_of_Calls = $bingo->createElement('text', 'pjpmaxcalls');
		$pjpmax_no_of_Calls->setLabel('PJP Max no of Calls');
		
		$pjpfixedReal = $bingo->createElement('text', 'pjpfixedReal');
		$pjpfixedReal->setLabel('PJP Fixed Amount Real');
				
		$pjpfixedBbs = $bingo->createElement('text', 'pjpfixedBbs');
		$pjpfixedBbs->setLabel('PJP Fixed Amount Bonus');
		
				
		
		$preBuyEnabled = $bingo->createElement('checkbox', 'preBuyEnabled');
		$preBuyEnabled->setLabel('Pre Buy Enabled')
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
		
		$realReturn = $bingo->createElement('text', 'realReturn');
		$realReturn->setLabel('Real Return (eg: 0.75 would be 75%)*')
				->setRequired(true);
				
		$bbsReturn = $bingo->createElement('text', 'bbsReturn');
		$bbsReturn->setLabel('Bonus Return (eg: 0.75 would be 75%)*')
				->setRequired(true);
				
		$minPotReal = $bingo->createElement('text', 'minPotReal');
		$minPotReal->setLabel('Minimum Real Pot *')
				->setRequired(true);
				
		$minPotBbs = $bingo->createElement('text', 'minPotBbs');
		$minPotBbs->setLabel('Minimum Bonus Pot *')
				->setRequired(true);
				
		$maxPotReal = $bingo->createElement('text', 'maxPotReal');
		$maxPotReal->setLabel('Maximum Real Pot *')
				->setRequired(true);
				
		$maxPotBbs = $bingo->createElement('text', 'maxPotBbs');
		$maxPotBbs->setLabel('Maximum Bonus Pot *')
				->setRequired(true);
				
		$bingo->addElements(array(
						$gameFlavour,
						$gameType,
						$category,
						$amountType,
						$potType,
						$pattern,
						$noOfParts,
						$cardPrice,
						$minCards,
						$maxCards,
						$freeRatio,
						$buyTime,
						$callDelay,
						$pjpEnabled,
						$pjp,
						$pjppercentReal,
						$pjppercentBbs,
						$pjpmax_no_of_Calls,
						$pjpfixedReal,
						$pjpfixedBbs,
						$preBuyEnabled,
						$realReturn,
						$bbsReturn,
						$minPotReal,
						$minPotBbs,
						$maxPotReal,
						$maxPotBbs));
		
		/*if($bingoSessNamespace)
		{
			$bingoSession = $bingo->createElement('hidden', 'bingoSession');
			$bingoSession->setValue($bingoSessNamespace);
			$bingo->addElement($bingoSession);
			
			$bingoCountSess = $bingo->createElement('hidden', 'bingoCountSess');
			$bingoCountSess->setValue($countSessNamespace);
			$bingo->addElement($bingoCountSess);
		}*/
		$bingo->setAttrib('id', 'admin-bingo-form');				
		return $bingo;
	}
	
	public function setForm($form, $data)
	{
		if($data['bingoGameId'])
		{
			$form->bingoGameId->setValue($data['bingoGameId']);
		}
		
		$form->name->setValue($data['name']);
		$form->description->setValue($data['description']);
		$form->gameFlavour->setValue($data['gameFlavour']);
		$form->gameType->setValue($data['gameType']);
		$form->amountType->setValue($data['amountType']);
		$form->potType->setValue($data['potType']);
		$form->pattern->setValue($data['patternId']);
		$form->noOfParts->setValue($data['noOfParts']);
		$form->cardPrice->setValue($data['cardPrice']);
		$form->minCards->setValue($data['minCards']);
		$form->maxCards->setValue($data['maxCards']);
		$form->freeRatio->setValue($data['freeRatio']);
		$form->buyTime->setValue($data['buyTime']);
		$form->callDelay->setValue($data['callDelay']);
		$form->pjpEnabled->setValue($data['pjpEnabled']);
		$form->preBuyEnabled->setValue($data['preBuyEnabled']);
		$form->realReturn->setValue($data['realReturn']);
		$form->bbsReturn->setValue($data['bbsReturn']);
		$form->minPotReal->setValue($data['minPotReal']);
		$form->minPotBbs->setValue($data['minPotBbs']);
		$form->maxPotReal->setValue($data['maxPotReal']);
		$form->maxPotBbs->setValue($data['maxPotBbs']);
		
		$form->pjppercentReal->setValue($data['pjppercentReal']);
		$form->pjppercentBbs->setValue($data['pjppercentBbs']);
		$form->pjpmaxcalls->setValue($data['pjpmaxcalls']);
		$form->pjpfixedReal->setValue($data['pjpfixedReal']);
		$form->pjpfixedBbs->setValue($data['pjpfixedBbs']);
		
		$form->category->setValue($data['category']);
		//Zenfox_Debug::dump($data);exit;
		return $form;
	}
	
	
}
