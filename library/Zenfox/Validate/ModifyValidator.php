<?php
/**
 * This class checks the field is modified or not
 * @author Nikhil Gupta
 * @date January 2, 2010
 */

//TODO implement other validations too

class Zenfox_Validate_ModifyValidator extends Zend_Validate_Identical
{
	const NOT_SAME      = 'notSame';
    const MISSING_TOKEN = 'missingToken';

    /**
     * Error messages
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_SAME      => "It can not be modified.",
        self::MISSING_TOKEN => 'No token was provided to match against',
    );
    
    public function __construct($token = NULL)
    {
    	parent::__construct($token);
    }
    
	public function isValid($value)
    {
        $this->_setValue((string) $value);
        $token        = $this->getToken();

        if ($token === null) {
            $this->_error(self::MISSING_TOKEN);
            return false;
        }

        if ($value !== $token)  {
            $this->_error(self::NOT_SAME);
            return false;
        }

        return true;
    }
}