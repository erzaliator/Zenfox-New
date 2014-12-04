<?php
class Admin_FrontendForm extends Zend_Form
{
	public function getForm()
	{
		$name = $this->createElement('text','name');
		$name->setLabel('Name *')
				->setRequired(true)
				->addValidator('Alnum');
				
		$description = $this->createElement('text','description');
		$description->setRequired(true)
					->setLabel('Description *');
		
		$siteCode = $this->createElement('text','siteCode');
		$siteCode->setLabel('Site Code *')
				->setRequired(true)
				->addValidator('StringLength',false,array(3));
				
		$contact = $this->createElement('text','contact');
		$contact->setLabel('Contact *')
				->setRequired(true);
		
		$url = $this->createElement('text','url');
		$url->setLabel('Url *')
			->setRequired(true)
			->addValidator(new UrlValidator);
		
		$amsUrl = $this->createElement('text','amsUrl');
		$amsUrl->setLabel('Ams Url *')
				->setRequired(true)
				->addValidator(new UrlValidator);

		$gmsUrl = $this->createElement('text','gmsUrl');
		$gmsUrl->setLabel('Gms Url *')
				->setRequired(true)
				->addValidator(new UrlValidator);
		
		$status = $this->createElement('select','status');
		$status->setLabel('Status *')
				->setRequired(true)
				->addMultiOption('ENABLED','ENABLED')
				->addMultiOption('DISABLED','DISABLED');
		
		$affiliateFrontendId = $this->createElement('select', 'affiliateFrontendId');
		$affiliateFrontendId->setLabel('Affiliate Frontend Id *')
				->setRequired(true);
		
		$affFrntend = new AffiliateFrontend();
		
		$affFrontends = $affFrntend->getAffiliateFrontends();
				
		foreach($affFrontends as $aFrontend)
		{
			$affiliateFrontendId->addMultiOption($aFrontend['id'],$aFrontend['name']);
		}
		
		
		$allowedFrontendIds = $this->createElement('multiCheckbox', 'allowedFrontendIds');
		$allowedFrontendIds->setLabel('Allowed Frontend Ids *');
		
		$frntend = new Frontend();
		$frntends = $frntend->getFrontends();
		
		foreach($frntends as $frend)
		{
			$allowedFrontendIds->addMultiOption($frend['id'],$frend['name']);
		}
		
		$currency = new Currency();
		$currencies = $currency->getCurrenies();
		
		/*$defaultCurrency = $this->createElement('select','defaultCurrency');
		$defaultCurrency->setLabel('Default Currency')
				->setRequired(true);
				
		foreach($currencies as $curr)
		{
			$defaultCurrency->addMultiOption($curr['currency_code'],$curr['currency_code']);
		}*/
		
		$defaultCurrency = $this->createElement('radio','defaultCurrency');
		$defaultCurrency->setLabel('Default Currency *')
				->setRequired(true);
				
				
				
		foreach($currencies as $curr)
		{
			$defaultCurrency->addMultiOption($curr['currency_code'],'');
		}
		
		$secondaryCurrencies = $this->createElement('multiCheckbox', 'secondaryCurrencies');
		$secondaryCurrencies->setLabel('Allowed  Currencies *')
							->setRequired(true);
							
		
		foreach($currencies as $curr)
		{
			$secondaryCurrencies->addMultiOption($curr['currency_code'],$curr['currency_code']);
		}
		
		$defaultBonusSchemeId = $this->createElement('select','defaultBonusSchemeId');
		$defaultBonusSchemeId->setLabel('Default Bonus Scheme Id *')
				->setRequired(true)
				->addMultiOption('1','bon1');
		
		$submit = $this->createElement('submit', 'submit');
        $submit->setLabel('Submit')
        		->setIgnore(true)
        		->setDecorators(array(

  

               'ViewHelper',

               'Description',

               'Errors', array(array('data'=>'HtmlTag'), array('tag' => 'td',

               'colspan'=>'2','align'=>'center')),

               array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

       ));
       
       
        		
        		
        		
		$this->addElements(array(
				$name,
				$description,
				$siteCode,
				$contact,
				$url,
				$amsUrl,
				$gmsUrl,
				$status,
				$affiliateFrontendId,
				$allowedFrontendIds,
				$defaultBonusSchemeId,
				$defaultCurrency,
				$secondaryCurrencies,
				$submit
			)
		);
		
		
		$defaultCurrency->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td', 'width' => 150)),

                   array('Label', array('tag' => 'tr')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr','openOnly'=>true))

  

           ));
           
		$secondaryCurrencies->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td', 'width' => 150)),

                   array('Label', array('tag' => 'tr')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr','closeOnly'=>true))

  

           ));
           
           
           
           	$label = $secondaryCurrencies->getDecorator('label');
			$label->setOption('placement', 'append');
        		
        $this->setDecorators(array(

  

               'FormElements',

          

               array(array('data'=>'HtmlTag'),array('tag'=>'table')),

          

               'Form'

  

       ));
		
		$this->setMethod('post');
		$this->setAttrib('id', 'admin-frontend-form');
		
		return $this;
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		
		$ids = $this->getKeys($data['allowed_frontend_ids']);
		$currencies = $this->getKeys($data['secondary_currencies']);
		$form->name->setValue($data['name']);
		$form->description->setValue($data['description']);
		$form->siteCode->setValue($data['site_code']);
		$form->contact->setValue($data['contact']);
		$form->url->setValue($data['url']);
		$form->amsUrl->setValue($data['ams_url']);
		$form->gmsUrl->setValue($data['gms_url']);
		$form->status->setValue($data['status']);
		$form->affiliateFrontendId->setValue($data['affiliate_frontend_id']);
		$form->allowedFrontendIds->setValue($ids);
		$form->defaultCurrency->setValue($data['default_currency']);
		$form->secondaryCurrencies->setValue($currencies);
		$form->defaultBonusSchemeId->setValue($data['default_bonus_scheme_id']);
		
		return $form;
	}
	
	public function getKeys($keysString)
	{
		$keys = explode(",",$keysString);
		return $keys;
	}
}
