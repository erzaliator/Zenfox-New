<?php

class Zenfox_DecoratorForm_Bingocrush
{
	public $openingTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'td')),
	array(array('row' => 'HtmlTag'), array('tag' => 'tr', 'openOnly' => true)));
	
	public $openingTableTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'td' , 'openOnly' => true, 'style'=>'height:70px;width:69px')),
	array(array('row' => 'HtmlTag'), array('tag' => 'table', 'openOnly' => true)));
	
	public $closingTableTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'td' , 'closeOnly' => true, 'style'=>'height:70px;width:69px')),
	array(array('row' => 'HtmlTag'), array('tag' => 'table', 'closeOnly' => true)));
	
	public $closingTdTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'td' , 'closeOnly' => true, 'style'=>'height:70px;width:69px')));
	
	public $openingTdTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'td' , 'openOnly' => true, 'style'=>'height:70px;width:69px')));
	
	public $closingTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'td')),
	array(array('row' => 'HtmlTag'), array('tag' => 'tr', 'closeOnly' => true)));
	
	public $changeTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'td')));
	
	public $openingButtonTagDecorator = array(
							'ViewHelper',
							'Errors',
	array('HtmlTag', array('tag' => 'td')),
	array(array('row' => 'HtmlTag'), array('tag' => 'tr', 'openOnly' => true)));
	
	public $closingButtonTagDecorator = array(
							'ViewHelper',
							'Errors',
	array('HtmlTag', array('tag' => 'td')),
	array(array('row' => 'HtmlTag'), array('tag' => 'tr', 'closeOnly' => true)));
	
	public $changeButtonTagDecorator = array(
							'ViewHelper',
							'Errors',
	array('HtmlTag', array('tag' => 'td')));
	
	public $linkDecorator = array(
							'ViewHelper',
							'Errors',
							'Description',
	array('Description', array('escape' => false, 'tag' => false)));
	
	public $facebookLinkDecorator = array(
							'ViewHelper',
							'Errors',
							'Description',
	array('HtmlTag', array('tag' => 'li', 'class' => 'facebook_button')),
	array('Description', array('escape' => false, 'tag' => false)));
	
	public $nextLinkDecorator = array(
							'ViewHelper',
							'Errors',
							'Description',
	array('HtmlTag', array('tag' => 'li')),
	array('Description', array('escape' => false, 'tag' => false)));
	
	public $nextLineDecorator = array(
							'ViewHelper',
							'Errors',
							'Label',
	array('HtmlTag', array('tag' => 'br')));
	
	public $changeLineDecorator = array(
							'ViewHelper',
							'Errors',
	array('HtmlTag', array('tag' => 'br')));
	
	public $openingUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li')),
	array(array('row' => 'HtmlTag'), array('tag' => 'ul', 'openOnly' => true)));
	
	public $closingUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li')),
	array(array('row' => 'HtmlTag'), array('tag' => 'ul', 'closeOnly' => true)));
	
	public $changeUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li')));
	
	public $changeUlButtonTagDecorator = array(
							'ViewHelper',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'class' => 'login_form_button')));
	
	public $closingUlButtonTagDecorator = array(
							'ViewHelper',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'class' => 'login_form_button ttsaveprofilelibg')),
	array(array('row' => 'HtmlTag'), array('tag' => 'ul', 'closeOnly' => true)));
	
	/* public $formJQueryElements = array(
	 'UiWidgetElement',
	'Errors',
	'Label',
	array('HtmlTag', array('tag' => 'li', 'class' => 'left'))); */
	public $formJQueryElements = array(
						    'UiWidgetElement',
						    'Errors',
							'Label',
	array('HtmlTag', array('tag' => 'li')));
		
	public $openingJqueryUlTagDecorator = array(
							'UiWidgetElement',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li')),
	array(array('row' => 'HtmlTag'), array('tag' => 'ul', 'openOnly' => true)));
		
	public $closingJqueryUlButtonTagDecorator = array(
							'UiWidgetElement',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'class' => 'login_form_button')),
	array(array('row' => 'HtmlTag'), array('tag' => 'ul', 'closeOnly' => true)));
	
	public $signupDecorator = array(
							'ViewHelper',
							'Errors',
							'Description',
	array('HtmlTag', array('tag' => 'li')),
	array('Description', array('escape' => false, 'tag' => false)),
	array(array('row' => 'HtmlTag'), array('tag' => 'ul', 'closeOnly' => true)));
	
	public $checkBoxDecorator = array(
							'ViewHelper',
							'Errors',
	array(array('input' => 'HtmlTag'), array('tag' => 'fieldset', 'class' => 'chkbox')),
							'Label',
	array('HtmlTag', array('tag' => 'li')));
	
	public $closingCheckBoxDecorator = array(
							'ViewHelper',
							'Errors',
	array(array('input' => 'HtmlTag'), array('tag' => 'fieldset', 'class' => 'customchkbox')),
							'Label',
	array('HtmlTag', array('tag' => 'li', 'class' => 'li_tag')));
	
	public $openingCheckBoxDecorator = array(
							'ViewHelper',
							'Errors',
	array(array('input' => 'HtmlTag'), array('tag' => 'fieldset', 'class' => 'chkbox')),
							'Label',
	array('HtmlTag', array('tag' => 'li')),
	array(array('row' => 'HtmlTag'), array('tag' => 'ul', 'openOnly' => true)));
	
	public $openingFileDecorator = array(
							'Errors',
							'Label',
	array('HtmlTag', array('tag' => 'li', 'class' => 'upload lipading')),
	array('file', array('file', array('tag' => 'ul', 'openOnly' => true))));
	
	public $closingFileDecorator = array(
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li')),
	array('file', array('file', array('tag' => 'ul', 'closeOnly' => true))));
	
	public $termsDecorator = array(
							'ViewHelper',
							'Errors',
							'Description',
	array('HtmlTag', array('tag' => 'li')),
	array('Description', array('escape' => false, 'tag' => false)));
	
	public $paymentCheckBoxDecorator = array(
							'ViewHelper',
							'Errors',
	array(array('input' => 'HtmlTag'), array('tag' => 'fieldset', 'class' => 'chkbox')),
							'Label',
	array('HtmlTag', array('tag' => 'li', 'id' =>'payment')));
	
	public $changeBankUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'bank_list')));
	
	public $changeCityUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'city_list')));
	
	public $changeNameUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_name')));
	
	public $changePlayerContactUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_contact')));
	
	public $changeEmailUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_email')));
	
	public $changeAddressDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'class' => 'li_tag', 'id' => 'address_box')));
	
	public $changePinCodeDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'pin_code')));
	
	public $changeContactDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'contact_no')));
	public $changeCouponDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'coupon_no')));
	
	public $changeIdProofDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_idproofother')));
	public $changeIdProofNoDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_idproofnumber')));
	public $changeIdProofAuthDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_idproofauthority')));
	public $changeIdProofExpDecorator = array(
							'UiWidgetElement',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_idproofexpiry')));
	
	public $changeAddressProofDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_otheraddressproof')));
	public $changeAddressProofNoDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_addressproofnumber')));
	public $changeAddressProofAuthDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_addressproofauthority')));
	public $changeAddressProofExpDecorator = array(
							'UiWidgetElement',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'id' => 'player_addressproofexpiry')));
	
	public $changeWithdrawalUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'class' => 'left ttdepopad_15')));
	
	public $changeWithdrawalLiTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'class' => 'left')));
	
	public $changeClearUlTagDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'class' => 'left clear ttdepopad_15')));
	
	public $changeNewsLetterDecorator = array(
							'ViewHelper',
							'Label',
							'Errors',
	array('HtmlTag', array('tag' => 'li', 'class' => 'clear')));
}