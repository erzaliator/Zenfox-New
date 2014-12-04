<?php
class Player_RediffController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		Zend_Layout::getMvcInstance()->setLayout('iframe_layout');
		//Zenfox_Debug::dump(Zend_Registry::get('webConfig'), 'config', true, true);
		$headers = array();
		foreach($_SERVER as $key => $value)
		{
			if(strpos($key, 'HTTP_X') === 0)
			{
				$headers[str_replace(' ', '-', str_replace('_', ' ', strtolower(substr($key, 5))))] = $value;
			}
		}
		$userid = $headers['x-redf-uid'];
		$_SESSION['rediffId'] = $userid;

		$accessToken = $_SERVER['HTTP_X_REDF_UAUTH'];
//		$this->_sendNotification($accessToken);
		
	}

	private function _sendNotification($accessToken)
	{
		$player = new Player();
		$allRediffPlayers = $player->getAllPlayers('email',0,'','','','rediff');
		foreach($allRediffPlayers as $rediffPlayer)
		{
			$explodeLoginName = explode('-', $rediffPlayer['Login Name']);
			if($explodeLoginName[1])
			{
                                $userIds[] = $explodeLoginName[1];
			}
		}
		$authkey = '8b755a409fc4bec289d4ebaf4c6998248a146f89';
                $referer = 'http://rediff.taashtime.com/rediff';//Callback URL

                $baseurl = "http://www.rediffapi.com/notifications?version=2";
                
		foreach($userIds as $userid)
		{
	                $curl = curl_init();
        	        $headers = array(
                	        "Connection: Close",
                        	"X-REDF-UID:".$userid,
	                        "X-REDF-AUTHKEY:".$authkey,
        	                "X-REDF-REFERER:".$referer,
                	        "X-REDF-UAUTH:".$accessToken,
	                );

        	        $xmlString = "<request><requestinfo><responsestyle>xml</responsestyle></requestinfo><content><requestedaction>sendNotification</requestedaction><notifications><notification><userid>$userid</userid><subject><![CDATA[Taashtime Invitation]]></subject><message><![CDATA[This is taashtime invitation.]]></message></notification></notifications></content></request>";

	                Zenfox_Debug::dump($xmlString, 'string');
        	        $param['xml'] = $xmlString;
                	curl_setopt($curl, CURLOPT_URL, $baseurl);
	                curl_setopt($curl, CURLOPT_HEADER, 0);
        	        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                	curl_setopt($curl, CURLOPT_POST,1);
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        	        curl_setopt($curl, CURLOPT_VERBOSE, 1);
                	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
	                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                
        	        $result = curl_exec($curl); 
                	Zenfox_Debug::dump($result, 'result');
	                echo "notification has been sent";
		}
	}
}