<?php
/**
 * This class implements the configuration form.
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class Admin_MainconfigForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	/*
	 * This function sets the roulette configuration form as well pjp forms
	 */
	public function setRouletteConfigForm($rouletteData, $pjpMachineData = NULL, $pjpEnabled = NULL, $option = NULL)
	{
        if($pjpEnabled)
        {
        	$rouletteForm = new Admin_RouletteconfigForm();
        	$rouletteForm->setRouletteForm($rouletteData);
        	$this->addSubForm($rouletteForm, 'roulette');
        	$this->addPjpForms($pjpMachineData);
        }
        
        else
        {
        	$rouletteForm = new Admin_RouletteconfigForm();
        	$rouletteForm->setRouletteForm($rouletteData);
        	$this->addSubForm($rouletteForm, 'roulette');
        }
        
/*		if($option)
        {
        	$this->addNewPjpForm();
        }
        if($pjpEnabled)
        {
        	$this->setPjpOption();	
        }*/
        $this->addSubmitButton();
        return $this;	
	}
	
	/*
	 * Get new roulette configuration form
	 */
	public function getNewRouletteForm()
	{
		$rouletteForm = new Admin_RouletteconfigForm();
		$rouletteForm->getRouletteForm();
		$this->addSubForm($rouletteForm, 'rouletteForm');
		$this->addPjpForms();
		$this->addSubmitButton();
		return $this;
	}
	
	/*
	 * Set Slot Configuration Form
	 */
	public function setSlotConfigForm($slotData, $pjpMachineData = NULL, $pjpEnabled = NULL)
	{
		if($pjpEnabled)
        {
        	$slotForm = new Admin_SlotConfigForm();
        	$slotForm->setSlotForm($slotData);
        	$this->addSubForm($slotForm, 'slot');
        	$this->addPjpForms($pjpMachineData);
        }
        
        else
        {
        	$slotForm = new Admin_SlotConfigForm();
        	$slotForm->setSlotForm($slotData);
        	$this->addSubForm($slotForm, 'slot');
        }
        
		/*if($option)
        {
        	$this->addNewPjpForm();
        }
        if($pjpEnabled)
        {
        	$this->setPjpOption();	
        }*/
        $this->addSubmitButton();
        return $this;	
	}
	
	public function getNewSlotForm($machineId)
	{
		$slotForm = new Admin_SlotConfigForm();
		$slotForm->getSlotForm($machineId);
		$this->addSubForm($slotForm, 'slotForm');
		$this->addPjpForms();
		$this->addSubmitButton();
		return $this;
	}
	
	/*
	 * Add pjp forms, after seting the values, in main form
	 */
	public function addPjpForms($pjpMachineData = NULL)
	{
        //$this->addNewPjpForm($pjpData);
		$pjp = new Pjp();
		$pjpData = $pjp->getPjpDetails();
		$i = 0;
		foreach($pjpData as $pjpDetail)
        {
        	$pjpForm[$i] = new Admin_PjpForm();
        	$temp = false;
        	if($pjpMachineData)
        	{
        		foreach($pjpMachineData as $machineData)
        		{
        			if($pjpDetail['id'] == $machineData['pjp_id'])
        			{
			        	$pjpForm[$i]->setPjpForm($machineData);
						$temp = true;
        			}
        		}
        	}
        	if(!$temp)
        	{
	        	$pjpForm[$i]->getPjpForm($pjpDetail['id']);
        	}
        	$this->addSubForm($pjpForm[$i], 'pjp_' . $pjpDetail['id']);
			$i++;
        }
	}
	
	/*
	 * Add new pjp form in main form
	 */
	/*public function addNewPjpForm($pjpMachineData = NULL)
	{
		$pjp = new Pjp();
		$pjpData = $pjp->getPjpDetails();
		$i = 0;
		foreach($pjpData as $pjpDetail)
        {
        	$temp = false;
        	if($pjpMachineData)
        	{
        		foreach($pjpMachineData as $machineData)
        		{
        			if($pjpDetail['id'] == $machineData['pjp_id'])
        			{
        				$temp = true;
        			}
        		}
        	}
        	if(!$temp)
        	{
        		$pjpForm[$i] = new Admin_PjpForm();
	        	$pjpForm[$i]->getPjpForm($pjpDetail['id']);
				$this->addSubForm($pjpForm[$i], 'pjp_' . $pjpDetail['id']);
				$i++;
        	}
        }
	}*/
	
	/*
	 * Add submit button in main form
	 */
	public function addSubmitButton()
	{
		$submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit All'))
        		->setIgnore(true);
        $this->addElement($submit);
	}
	
	/*
	 * Check to want add new pjp form
	 */
	public function setPjpOption()
	{
		$option = $this->createElement('radio', 'option');
		$option->setLabel('Do you want to add another Pjp?')
				->addMultiOption('1', 'Yes')
				->addMultiOption('0', 'No')
				->setValue(0);
		$this->addElement($option);
	}
	
	public function getBingoForm($noOfParts = NULL, $gameType = NULL)
	{		
		$bingo = new Admin_BingoForm();
		$bingoForm = $bingo->getBingoForm();
		$this->addSubForm($bingoForm, 'bingo');
		/*for($i = 0; $i < 2; $i++)
		{
			$variablePot = new Admin_VariablePotForm();
			$variablePotForm = $variablePot->getVariablePotForm();
			$this->addSubForm($variablePotForm, 'varPot_' . $i);
		}*/
		if($noOfParts)
		{
			for($i = 0; $i < $noOfParts; $i++)
			{
				if($gameType == 'VARIABLE')
				{
					$variablePot = new Admin_VariablePotForm();
					$variablePotForm = $variablePot->getVariablePotForm();
					$this->addSubForm($variablePotForm, 'varPot_' . $i);
				}
				if($gameType == 'FIXED')
				{
					$fixedPot = new Admin_FixedPotForm();
					$fixedPotForm = $fixedPot->getFixedPotForm();
					$this->addSubForm($fixedPotForm, 'fixed_' . $i);
				}
			}
		}
	}
	
	public function prepareSubForm($spec)
    {
        if (is_string($spec)) {
            $subForm = $this->{$spec};
        } elseif ($spec instanceof Zend_Form_SubForm) {
            $subForm = $spec;
        } else {
            throw new Exception('Invalid argument passed to ' .
                                __FUNCTION__ . '()');
        }
        $this->setSubFormDecorators($subForm)
             ->addSubSubmitButton($subForm)
             ->addSubFormActions($subForm);
        return $subForm;
    }

    /**
     * Add form decorators to an individual sub form
     *
     * @param  Zend_Form_SubForm $subForm
     * @return My_Form_Registration
     */
    public function setSubFormDecorators(Zend_Form_SubForm $subForm)
    {
        $subForm->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl',
                                   'class' => 'zend_form')),
            'Form',
        ));
        return $this;
    }

    /**
     * Add a submit button to an individual sub form
     *
     * @param  Zend_Form_SubForm $subForm
     * @return My_Form_Registration
     */
    public function addSubSubmitButton(Zend_Form_SubForm $subForm)
    {
        $subForm->addElement(new Zend_Form_Element_Submit(
            'save',
            array(
                'label'    => 'Save and continue',
                'required' => false,
                'ignore'   => true,
            )
        ));
        return $this;
    }

    /**
     * Add action and method to sub form
     *
     * @param  Zend_Form_SubForm $subForm
     * @return My_Form_Registration
     */
    public function addSubFormActions(Zend_Form_SubForm $subForm, $gameType = NULL)
    {
        $subForm->setAction('/bingo/edit')
                ->setMethod('post');
        return $this;
    }
}