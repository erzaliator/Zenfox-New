<?php

//class IndexController extends Zend_Controller_Action
//require_once('Zenfox/BridgeController.php');
class Player_IndexController extends Zenfox_Controller_Action
{

    public function init()
    {
        //FIXME:: This has to be called all the time. There should be a way to fix it.
        parent::init();

        /* Initialize action controller here */
        $this->view->message = $this->view->translate("This is the player website");
    }

    public function indexAction()
    {
        // action body
    }

}

