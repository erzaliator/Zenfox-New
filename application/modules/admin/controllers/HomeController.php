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
class Admin_HomeController extends Zenfox_Controller_Action
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
        $session = new Zenfox_Auth_Storage_Session();
        $data = $session->read();
        if(!$data)
        {
        	$this->_redirect($language . '/error/error');
        }
        $this->view->loginName = $data['authDetails'][0]['name'];
    }
}