<?php
/**
 * This file contains Zenfox_Controller_Action class which extends
 * Zend_Controller_Action
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox_Controller
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @version    $Id:$
 * @since      File available since v 0.1
*/

/**
 * This class extends Zend_Controller_Action to give more flexibility to
 * controllers
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenf_Controller
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */
class Zenfox_Controller_Action extends Zend_Controller_Action
{
    public function init()
    {
        //$this->view->setScriptPath('/path/to/your/view/script/directory');
        /*
         * This is the default directory. More these can be added by changing
         * Or extending this by another config file
        */
        parent::init();
    }
}