<?php
/**
 * This class checks if user name is valid or not.
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class Zenfox_Validate_UsernameValidator extends Zend_Validate_Abstract
{
	const INVALID_USERNAME = 'invalidUsername';
	const INVALID_NAME = 'invalidName';

	protected $_messageTemplates = array(
        self::INVALID_USERNAME   => "Your username can only contain letters, numbers and underscores (_).",
		self::INVALID_NAME   => "Username should not be start with ch_",
    );
	
	public function isValid($value)
	{
		$n = strlen($value);
		if(preg_match('/^ch_/i', $value))
		{
			$this->_error(self::INVALID_NAME);
			return false;
		}
		for($i=0 ; $i<$n ; $i++)
		{
			//TODO implement it for other characters also
			if(($value[$i] == '!') || ($value[$i] == '$') || ($value[$i] == '#')
				|| ($value[$i] == '@') || ($value[$i] == '%') || ($value[$i] == '^')
				|| ($value[$i] == '&') || ($value[$i] == '*') || ($value[$i] == '(')
				|| ($value[$i] == ')') || ($value[$i] == '-') || ($value[$i] == '+')
				|| ($value[$i] == '=') || ($value[$i] == '`') || ($value[$i] == '~')
				|| ($value[$i] == '{') || ($value[$i] == '}') || ($value[$i] == '[')
				|| ($value[$i] == ']') || ($value[$i] == '|') || ($value[$i] == '<')
				|| ($value[$i] == '>') || ($value[$i] == '>') || ($value[$i] == '?')
				|| ($value[$i] == '/') || ($value[$i] == '\\') || ($value[$i] == ' '))
			{
				$this->_error(self::INVALID_USERNAME);
            	return false;
			}
		}
		return true;
	}
}