<?php
require_once dirname(__FILE__).'/../forms/SampleForm.php';
class SampleController extends Zenfox_Controller_Action
{
    public function init()
    {
    }
    
    public function createAction()
    {
        $session = new Zend_Auth_Storage_Session();
        $store = $session->read();
        $playerId = $store['playerID'];
        $clientId = $store['clientID'];
        $appId = $store['appID'];
        $badge = new Badge($playerId, $clientID, $appID);
        $form = new SampleForm();
        $this->view->form = $form;
        /*$csrIds = new CsrIds();
        $ids = $csrIds->getIds();
        $this->view->csrIds = $ids;*/
        if($this->getRequest()->isPost())
        {
            if($form->isValid($_POST))
            {//Zenfox_Debug::dump($_POST, 'post',true,true);
                $data = $form->getValues();
                $ticketType = 'player';
                //TODO get user id from url
                //Done got the user_id from form data
                $login = new CsrIds();
                if($ticketType == 'affiliate')
                {
                    $user_id = $login->getAffiliateId($data['userName']);
                }
                else
                {
                    $user_id = $login->getUserId($data['userName']);
                }
                 $player = new Player();
                $playerfrontendid = $player->getfrontendidofplayer($user_id);
                if (in_array($playerfrontendid,$csrfrontendids))
                {
                    if($ticket->createTicket($data, $user_id, $ticketType))
                    {
                    //echo 'in here';
                        $form = new Admin_TicketForm();
                        $this->view->form = $form;
                        $this->view->message = $this->view->translate("Your message has been sent");
                        $this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your message has been sent")));
                    }
                }
                else
                {
                    $this->_helper->FlashMessenger(array('error' => $data['userName']." not found or You are not authorised to view/edit this player's details"));
                }
                
            }
        }
    }
    
    public function replyAction()
    {
        $session = new Zend_Auth_Storage_Session();
        $store = $session->read();
        $userType = $store['roleName'];
        $playerId = $store['id'];
        $ticket = new Tickets($playerId, $userType);
        $form = new Admin_ReplyForm();
        $this->view->form = $form;
        $ticketData = $this->_getTicketData($this->getRequest()->ticket_id, $this->getRequest()->user_id, $this->getRequest()->userType);
        $form->ticket_status->setValue($ticketData['lastTicketStatus']);
        //
        /*$message = $ticket->showTicket($this->getRequest()->ticket_id, $this->getRequest()->user_id, $this->getRequest()->userType);
        
        $fromName = array();
        $toName = array();
        foreach($message as $tickets)
        {
            $lastTicketStatus = $tickets['ticket_status'];
        }
        $form->ticket_status->setValue($lastTicketStatus);
        foreach($message as $msg)
        {
            if($msg['sent_by'] == 'CSR')
            {
                $csr = new CsrIds();
                if($msg['ticket_status'] == 'FORWARDED')
                {
                    $receiver = $csr->getForwardedCsrName($msg['time'], $msg['user_id']);
                }
                else
                {
                    $receiver = $csr->getPlayerLogin($msg['user_id']);
                }
                $sender = $csr->getCsrName($msg['owner']);
            }
            if($msg['sent_by'] == 'PLAYER')
            {
                $player = new CsrIds();
                $sender = $player->getPlayerLogin($msg['user_id']);
                $receiver = 'CSR';
            }
            if($msg['sent_by'] == 'AFFILIATE')
            {
                $affiliate = new CsrIds();
                $sender = $affiliate->getAffiliateAlias($msg['user_id']);
                $receiver = 'CSR';
            }
            $fromName[] = $sender;
            $toName[] = $receiver;
        }
        $csrIds = new CsrIds();
        $this->view->sender = $fromName;
        $this->view->receiver = $toName;
        $this->view->messages = $message;
        $this->view->csrIds = $csrIds->getIds();
        $index = 0;
        $messageContent = array();
        foreach($message as $messageData)
        {
            $messageContent[$index]['From'] = $fromName[$index];
            $messageContent[$index]['To'] = $toName[$index];
            $messageContent[$index]['Message'] = $messageData['reply_msg'];
            $messageContent[$index]['Time'] = $messageData['time'];
            $index++;
        }
        $this->view->contents = $messageContent;*/
        //$this->_helper->FlashMessenger(array('notice' => $this->view->translate($message)));
        if($this->getRequest()->isPost())
        {//Zenfox_Debug::dump($_POST ,'relpy',true,true);
            if($form->isValid($_POST))
            { 
                $data = $form->getValues();
                
                //Zenfox_Debug::dump('-ticket_id-'.$this->getRequest()->ticket_id.'-id-'. $this->getRequest()->id.'-ticketType-'. $this->getRequest()->ticketType ,'relpy',true,true);
                $ticket->replyTicket($data, $this->getRequest()->ticket_id, $this->getRequest()->user_id, $this->getRequest()->userType);
                $form = new Admin_ReplyForm();
                $this->view->form = $form;
                //$this->view->message = $this->view->translate('Your reply has been sent.');
                $this->view->sent = 'sent';
                $this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your reply has been sent.")));
                $ticketData = $this->_getTicketData($this->getRequest()->ticket_id, $this->getRequest()->user_id, $this->getRequest()->userType);
            }
        }
        $this->view->sender = $ticketData['fromName'];
        $this->view->receiver = $ticketData['toName'];
        $this->view->messages = $ticketData['message'];
        $this->view->csrIds = $ticketData['csrIds'];
        $this->view->contents = $ticketData['messageContent'];
    }
    
    private function _getTicketData($ticketId, $userId, $userType)
    {
        $session = new Zend_Auth_Storage_Session();
        $store = $session->read();
        $userType = $store['roleName'];
        $playerId = $store['id'];
        $ticket = new Tickets($playerId, $userType);
        
        $message = $ticket->showTicket($ticketId, $userId, $userType);
        /*
         * Taking the value from the database and set into form
         */
        $fromName = array();
        $toName = array();
        foreach($message as $tickets)
        {
            $lastTicketStatus = $tickets['ticket_status'];
        }
        
        foreach($message as $msg)
        {
            if($msg['sent_by'] == 'CSR')
            {
                $csr = new CsrIds();
                if($msg['ticket_status'] == 'FORWARDED')
                {
                    $receiver = $csr->getForwardedCsrName($msg['time'], $msg['user_id']);
                }
                else
                {
                    $receiver = $csr->getPlayerLogin($msg['user_id']);
                }
                $sender = $csr->getCsrName($msg['owner']);
            }
            if($msg['sent_by'] == 'PLAYER')
            {
                $player = new CsrIds();
                $sender = $player->getPlayerLogin($msg['user_id']);
                $receiver = 'CSR';
            }
            if($msg['sent_by'] == 'AFFILIATE')
            {
                $affiliate = new CsrIds();
                $sender = $affiliate->getAffiliateAlias($msg['user_id']);
                $receiver = 'CSR';
            }
            $fromName[] = $sender;
            $toName[] = $receiver;
        }
        $csrIds = new CsrIds();
        $allCsrIds = $csrIds->getIds();
        $index = 0;
        $messageContent = array();
        foreach($message as $messageData)
        {
            $ticketTime = $messageData['time'];
            $messageContent[$index]['From'] = $fromName[$index];
            $messageContent[$index]['To'] = $toName[$index];
            $messageContent[$index]['Message'] = $messageData['reply_msg'];
            if($messageData['ticket_status'] == 'FORWARDED')
            {
                $messageContent[$index]['Note'] = $messageData['note'];
            }
            $messageContent[$index]['Time'] =  date ("Y-m-d H:i:s", strtotime("$ticketTime, + 5 HOUR 30 MINUTE"));
            $index++;
        }

        return array(
            'lastTicketStatus' => $lastTicketStatus,
            'fromName' => $fromName,
            'toName' => $toName,
            'message' => $message,
            'csrIds' => $allCsrIds,
            'messageContent' => $messageContent
        );
    }
}
