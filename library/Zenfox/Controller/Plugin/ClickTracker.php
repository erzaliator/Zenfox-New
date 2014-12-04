<?php
class Zenfox_Controller_Plugin_ClickTracker extends Zend_Controller_Plugin_Abstract 
{
	private $_today;
	private $_trackerId;
	
	public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
    	//echo 'in plugin';
    	$this->_today = new Zend_Date();
    	//setcookie('tracking[trackerId]','',time() + (86400 * 30),'/','.zenfox.tld');
    	$cookie = isset($_COOKIE['tracking']['trackerId'])?$_COOKIE['tracking']['trackerId']:null;
    	//$request = $this->getRequest();
    	//echo '$request->trackerId = '.$request->trackerId;
    	//echo 'tracker_id = '.$trackerId;
    	if($cookie)
		{
			//echo 'trackerId'.$_COOKIE['tracking']['trackerId'];
			$cookieDate = $_COOKIE['tracking']['date'];
			if(time()-$cookieDate <= (30*86400))
			{
				$trackerId = $_COOKIE['tracking']['trackerId'];
				$this->_trackerId = $trackerId;
			}
				
			//echo 'cookie exists';
		}
		
		else
		{
			if($request->trackerId)
	    	{
	    		$trackerId = $request->trackerId;
	    		$this->_trackerId = $trackerId;
	    		
	    		/*
	    		setcookie('tracking[trackerId]',$trackerId,time() + (86400 * 30),'/','.zenfox.tld');
				setcookie('tracking[date]',time(),time() + (86400 * 30),'/','.zenfox.tld');
				*/ 
	    		
	    		setcookie('tracking[trackerId]',$trackerId,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
				setcookie('tracking[date]',time(),time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
	    	}
			
			/*$cookie = new Zend_Http_Cookie('tracking',

                               'two words',

                               '.zenfox.tld',

                               time() + 7200,

                               '/');
			$client = new Zend_Http_Client();
			$client->setUri('http://zenfox.tld');
			
			$client->setConfig(array(

    		'maxredirects' => 10,

    		'timeout'      => 30));
			$client->setCookie($cookie);*/
			//echo 'cookie created';
		}
    	$trackerId = $this->_trackerId;
    	
    	if($trackerId)
		{
			$session = new Zend_Session_Namespace('playerTrackerId');
			$session->trackerId = $trackerId;
			$hitDatetime = $this->_today->get(Zend_Date::W3C);
			$arr = explode('T',$hitDatetime);
			$hitDate = $arr[0];
			$arr1 = explode('+',$arr[1]);
			$time = $arr1[0];
			$hitDatetime = $hitDate.' '.$time;
			
			$ip = $request->getServer('REMOTE_ADDR');
			//echo '**'.$ip;
			
			$data = array();
			$data['trackerId'] = $trackerId;
			$data['hitDatetime'] = $hitDatetime;
			$data['hitDate'] = $hitDate;
			$data['ip'] = $ip;
			$clickTrack = new ClickTrack();
			$clickTrack->insertdata($data);
			
		}
		//echo 'trackerId'.$trackerId;
    }
    
}