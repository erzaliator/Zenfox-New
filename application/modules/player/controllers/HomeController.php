<?php
/**
 * This file contains Player_HomeController class which extends
 * Zenfox_Controller_Action.
 * This is where the ACLs are decided depending on the moduleName
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Player
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @version    $Id:$
 * @since      File available since v 0.1
*/

/**
 * This class extends Zend_Controller_Action.
 * This handles all home actions
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Player
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */
class Player_HomeController extends Zenfox_Controller_Action
{
    public function init()
    {
        parent::init();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('index', 'json')
              			->initContext();
    }

    public function indexAction()
    {
    	$language = $this->getRequest()->getParam('lang');
//    	$player = new Player();
//    	$player->getAllPlayers();
/*    	$cache = Zend_Registry::getInstance()->get('Cache');
    	print "HERE!!";
    	$key = 'playerSession_nikhil';
    	if($cache->test($key))
    	{
    		echo "hi";
    		print( "Data -- > " .$cache->load($key));
    	}*/
        $session = new Zenfox_Auth_Storage_Session();
        $data = $session->read();
        if(!$data)
        {
            $this->_redirect($language . '/auth/login');
        }
       	//TODO for local testing, can comment out this
    	if($this->getRequest()->format != 'json')
    	{
    		$player = new Player();
    		$player->updateLastLogin($data['id']);
    		//$this->_redirect($language . '/game/index');
    	}
    	$firstName = $data['authDetails'][0]['first_name'];
    	$loginName = $data['authDetails'][0]['login'];
    	$displayName = empty($firstName)?$loginName:$firstName;
        //$this->view->displayName = $displayName;

	$playerId = $data['id'];
	$freeChips = 0;
    	$accountVariable = new AccountVariable();
    	$varData = $accountVariable->getData($playerId, 'freeMoney');
    	if($varData)
    	{
    		$freeChips = round($varData['varValue'], 2);
    	}
	/*$userData['user_name'] = $displayName;
	$userData['balance'] = $data['authDetails'][0]['cash'];
    	$userData['loyalty_points'] = $data['authDetails'][0]['total_loyalty_points'];
    	$userData['free_chips'] = $freeChips;
    	$userData['bonus'] = $data['authDetails'][0]['bonus_bank'] + $storedData['authDetails'][0]['bonus_winnings'];*/
	$cash = $data['authDetails'][0]['bank'] + $data['authDetails'][0]['winnings'] + $data['authDetails'][0]['bonus_bank'] + $data['authDetails'][0]['bonus_winnings'];
	$bonus = 0;
	if($data['authDetails'][0]['noof_deposits'])
	{
		$bonus = $data['authDetails'][0]['bonus_due'];
	}
    	
    	$userData['user_name'] = $displayName;
    	$userData['balance'] = $cash;
    	$userData['loyalty_points'] = $data['authDetails'][0]['total_loyalty_points'];
    	$userData['free_chips'] = $freeChips;
    	$userData['bonus'] = $bonus;
        //$this->view->displayName = $displayName;
        $this->view->success = $userData;
      //  $role = explode('-', $data['id']);
    }
}