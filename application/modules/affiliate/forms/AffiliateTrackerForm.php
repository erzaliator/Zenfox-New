<?php
class Affiliate_AffiliateTrackerForm extends Zend_Form
{
	public function getForm()
	{
		$trackerType = $this->createElement('select','trackerType');
		$trackerType->setLabel($this->getView()->translate('Tracker Type *'))
					->setRequired(true);
					
		$trackerType->addMultiOption('ONLINE','ONLINE');
		$trackerType->addMultiOption('OFFLINE','OFFLINE');
		
		$trackerName = $this->createElement('text','trackerName');
		$trackerName->setLabel($this->getView()->translate('Tracker Name *'))
				->setRequired(true);
				
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		$this->addElements(array(
					$trackerType,
					$trackerName,
					$submit
				));
				
		$this->setMethod('post');
		
		return $this;
					
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		$form->trackerType->setValue($data['tracker_type']);
		$form->trackerName->setValue($data['tracker_name']);
		
		return $form;
	}
	
	public function getBannerForm()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$storage = $session->read();
		$affiliateId = $storage['id'];
		$trackerId = $this->createElement('select', 'trackerId');
		$trackerId->setLabel('Tracker');
		$affiliateTracker = new AffiliateTracker();
		$affiliateTrackerData = $affiliateTracker->getAffiliateTrackersByAffiliateId($affiliateId);
		foreach($affiliateTrackerData as $trackerData)
		{
			//$trackerId->addMultiOption($trackerData['tracker_id'], 'TRACKER-' . $trackerData['tracker_id']);
			$trackerId->addMultiOption($trackerData['tracker_id'], $trackerData['tracker_name']);
		}
		
		$frontendInstance = new Frontend();
		$frontendIds = explode(',', $storage['allowed_frontend_ids']);
		$frontendId = $this->createElement('select', 'frontendId');
		$frontendId->setLabel('Frontend');
		foreach($frontendIds as $frontend_id)
		{
			$frontendData = $frontendInstance->getFrontendById($frontend_id);
			$frontendName = $frontendData[0]['name'];
			$frontendId->addMultiOption($frontend_id, $frontendName);
		}
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
			->setIgnore(true);

		$this->addElements(array(
					$trackerId,
					$frontendId,
					$submit,
				));
		return $this;			
					
	}
	
	public function getOptions()
	{
		$options = $this->createElement('select', 'options');
		$options->setLabel('Report Type')
				->addMultiOptions(array(
						'day' => 'Daily',
						'week' => 'Weekly',
						'month' => 'Monthly',
				));
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
			->setIgnore(true);
			
		$this->addElements(array(
				$options,
				$submit,
			));
			
		return $this;
	}
	
	public function chooseBannerForm()
	{
		$facebookDescription = '<a href = "#" onClick="facebookLogin()"><img src="/images/facebook-login-button.png" /></a>';
		
		$facebookLogin = $this->createElement('radio', 'facebookLogin');
		$facebookLogin->addMultiOptions(array(
							'login' => $facebookDescription,
							
					       ));	
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
			->setIgnore(true);
		
		$this->addElements(array(
				$facebookLogin,
				$submit
			));
		
		$decorator = new Zenfox_DecoratorForm();
		
		$facebookLogin->setDecorators($decorator->facebookLinkDecorator);
		
		return $this;
	}
}