<?php
class Zenfox_Applications_Platform_Ibibo extends Zenfox_Applications
{
	private $_userData;
	
	public function __construct()
	{
		
	}
	
	public function setUserData()
	{
		$rand_num = rand();
		$app_secret = '29285408472608849247';
		$consumer_key = 79921;
		$msg = $rand_num.'|'.$consumer_key.'|'.$app_secret;
		$signature = base64_encode(md5($msg,true));       
		$post_data['request_token']  = $rand_num;
	    	$post_data['consumer_key']  = $consumer_key;
	    	$post_data['sig']    = $signature;
	    	$statusUrl = "http://apps.ibibo.com/oauth/getAccessToken";
		$url = str_replace(" ","%20",$statusUrl);
		//$statusOut = $this->utils->getDataCurl($url,$post_data);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$statusOut = curl_exec($ch);
		curl_close($ch);
		
		$access_token_arr = json_decode($statusOut);
		$access_result = json_decode($statusOut,true);

		if($access_result['result'] == 'success')
		{
			$access_token = $access_result['access_token'];
			@header('P3P: CP="CAO COR CURa ADMa DEVa OUR IND ONL COM DEM PRE"');
			setcookie("access_token",$access_token,time()+2400);
			// authorize app
			$auth_post['access_token'] = $access_token;
			$auth_post['app_id'] = $consumer_key;
			$app_id = $consumer_key;
			$auth_msg = $app_id."|".$access_token."|".$app_secret;
			$auth_sign = base64_encode(md5($auth_msg,true));
			$surl = "http://apps.ibibo.com/taash";
			$authorizeurl = "http://apps.ibibo.com/oauth/authorize";
			$authorizeurl = str_replace(" ","%20",$authorizeurl);
			$authUrl = $authorizeurl."?access_token=".$access_token."&sig=".$auth_sign."&app_id=".$app_id."&surl=".$surl."&&scope=basic_info,user_friends,publish_stream,user_photos";
			//if(isset($_COOKIE['access_token'] ))
			//{
				$result = $this->__getUserInfo($_COOKIE['access_token']);
				$ibiboSession = new Zend_Session_Namespace('IbiboSession');
				$ibiboSession->value = $_COOKIE['access_token'];
				
				if($result == "failed")
				{
						echo("<script> top.location.href='" . $authUrl . "'</script>");
				}
				else
				{
					$playerData['login'] = $result['uid'];
					$playerData['firstName'] = $result['cn'];
					$playerData['lastName'] = $result['sn'];
					$playerData['email'] = $result['mail'];
					$dob = explode('/', $dob);
					$playerData['dateOfBirth'] = $dob[2] . '-' . $dob[0] . '-' . $dob[1];
					
					$this->_userData = $playerData;
					$this->__register();
					//return true;
					return array(
						'success' => true
					);
				}	
			//}	
		}
	}
	
	private function __getUserInfo($access_token="")
	{
		$post_data['access_token'] = $access_token;
		$post_data['app_id'] = 79921;
		$userInfoUrl = "http://apps.ibibo.com/method/getUserInfo";
		$url = str_replace(" ","%20",$userInfoUrl);

		$ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $statusOut = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($statusOut,true);
		//var_dump($result);
		if($result['result'] == "failed")
		{
			return $result['result'];
		}
		else
		{
			return $result['basicInfo'];
		}		
	}
	
	private function __register()
	{
		parent::registerPlayer($this->_userData);
	}
}