<?php
class Player_MainForm extends Zend_Form
{
	private $_form1;
	private $_form2;
	private $_noOfParts;
	
	public function __construct($form1 = NULL, $form2 = NULL, $noOfParts = NULL)
	{
		$this->_form1 = $form1;
		$this->_form2 = $form2;
		$this->_noOfParts = $noOfParts;
	}
	
	/**
	 * Get all the sub forms and add in main form 
	 * @return unknown_type
	 */
	public function getForm()
	{
		$form1 = $this->_form1->getForm();
		$this->addSubForm($form1, 'form1');
		if($this->_noOfParts)
		{
			for($i =0; $i < $this->_noOfParts; $i++)
			{
				$form2 = $this->_form2->getForm();
				$this->addSubForm($form2, 'form2_' . $i);
			}
		}
		return $this;
	}
	
	/**
	 * set the form values
	 * @param $formKey
	 * @param $data
	 * @return unknown_type
	 */
	public function setForm($formKey, $data)
	{
		if($formKey == 'form1')
		{
			$form = $this->_form1;
		}
		else
		{
			$form = $this->_form2;
		}
		$form = $form->setForm($this->getSubForm($formKey), $data);
		return $form;
	}
	
	/**
	 * prepare the form to be displayed
	 * @param $spec
	 * @param $controller
	 * @param $action
	 * @param $formSessNamespace
	 * @param $countSessNamespace
	 * @return unknown_type
	 */
	public function prepareSubForm($spec, $controller, $action, $formSessNamespace, $countSessNamespace)
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
             ->addSubFormActions($subForm, $controller, $action)
             ->addSessions($subForm, $formSessNamespace, $countSessNamespace);
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
            'next',
            array(
                'label'    => $this->getView()->translate('Next'),
                'required' => false,
                'ignore'   => true,
            )
        ));
        $subForm->addElement(new Zend_Form_Element_Submit(
            'prev',
            array(
                'label'    => $this->getView()->translate('Previous'),
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
    public function addSubFormActions(Zend_Form_SubForm $subForm, $controller, $action)
    {
        $subForm->setAction('/' . $controller . '/' . $action)
                ->setMethod('post');
        return $this;
    }
    
    public function addSessions(Zend_Form_SubForm $subForm, $formSessNamespace, $countSessNamespace)
    {
    	$formSession = $subForm->createElement('hidden', 'formSession');
		$formSession->setValue($formSessNamespace);
		$subForm->addElement($formSession);
		
		$countSession = $subForm->createElement('hidden', 'countSession');
		$countSession->setValue($countSessNamespace);
		$subForm->addElement($countSession);
    }
    
    public function getCurrentSubForm($countSessNamespace = NULL)
    {
    	if(!$countSessNamespace)
    	{
    		return false;
    	}
    	
    	//Use controller as session namespace
    	//Manage the counter
    	$session = new Zend_Session_Namespace($countSessNamespace);
    	if(!$session->value)
    	{
    		$session->value = 1;
    	}
    	$temp = $session->value;
    	foreach($this->getSubForms() as $key => $value)
    	{
    		$temp--;
    		if(!$temp)
    		{
    			return $this->getSubForm($key);
    		}
    	}
    }
    
    /**
     * Is the sub form valid?
     *
     * @param  Zend_Form_SubForm $subForm
     * @param  array $data
     * @return bool
     */
    public function subFormIsValid(Zend_Form_SubForm $subForm,
                                   array $data, $namespace)
    {
        $name = $subForm->getName();
        
        if ($subForm->isValid($data)) {
            $namespace->$name = $subForm->getValues();
            return true;
        }

        return false;
    }

    /**
     * Is the full form valid?
     *
     * @return bool
     */
    public function formIsValid($countSessNamespace, $noOfParts)
    {
    	$session = new Zend_Session_Namespace($countSessNamespace);
    	$counter = $session->value;
    	if(($counter - 1) == $noOfParts)
    	{
    		return true;
    	}
    	return false;
    }
    
    /**
     * Set the counter value in session
     */
    public function setCounter($countSessNamespace, $page)
    {
    	$session = new Zend_Session_Namespace($countSessNamespace);
    	$counter = $session->value;
    	if($page == 'next')
    	{
			$counter++;
    	}
    	elseif($page == 'prev')
    	{
			$counter--;
    	}
    	$session->value = $counter;
    	return $counter;
    }
	//Set the session according to the actions
    //It is used for multiple browser windows
    
    public function setSession($action)
    {
    	$session = new Zend_Session_Namespace('Action');
    	//$session->unsetAll();
    	$sessNamespace = array();
    	$sessionData = $session->action;
    	if($sessionData)
    	{
	    	foreach($sessionData as $index => $value)
	    	{
	    		if($index == $action)
	    		{
	    			$i = count($value);
	   				$value[$i] = $action . '_' . $i;
	   				$sessionData[$action] = $value;
	   				$session->action = $sessionData;
	   				return $value[$i];
	    		}
	    		$sessionData[$action] = $value;
	    	}
    	}
    	$sessNamespace[0] = $action . '_' . 0;
    	$sessionData[$action] = $sessNamespace;
    	$session->action = $sessionData;
    	return $sessNamespace[0];
    }
    
    //Delete all the sessions
    //FIXME some one closed the session in the middle
    
    public function deleteSession($sessionNamespace, $countSessNamespace = NULL)
    {
    	$session = new Zend_Session_Namespace($sessionNamespace);
    	//Check if there is any action session, make it null if it is current action session
    	if($sessionNamespace == 'Action')
    	{
    		$sessionData = array();
    		$action = 0;
	    	foreach($session->action as $index => $value)
	    	{
	    		foreach($value as $sessionKey => $namespace)
	   			{
	   				if($namespace == $countSessNamespace)
	   				{
	   					$value[$sessionKey] = NULL;
	   				}
	   				if($value[$sessionKey])
	   				{
	   					$action++;
	   				}
	   				$sessionData[$index] = $value;
	   			}	
	    	}
	    	$session->action = $sessionData;
	    	if(!$action)
	    	{
//	    		echo "all deleted";
	    		$session->unsetAll();
	    	}
    	}
    	else
    	{
    		$session->unsetAll();
    	}
    }
}