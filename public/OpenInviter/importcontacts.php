<?php
include('openinviter.php');
//print_r($_POST);
$inviter=new OpenInviter();
$oi_services=$inviter->getPlugins();

if (isset($_POST['provider_box'])) 
{
	if (isset($oi_services['email'][$_POST['provider_box']])) $plugType='email';
	elseif (isset($oi_services['social'][$_POST['provider_box']])) $plugType='social';
	else $plugType='';
}
else $plugType = '';

function ers($ers)
	{
	if (!empty($ers))
		{
		$contents="<table cellspacing='0' cellpadding='0' style='margin-top: 13px; width: 260px;' align='center'><tr><td valign='middle' style='padding:3px' valign='middle'></td><td valign='middle' style='color:red;padding:5px;'>";
		foreach ($ers as $key=>$error)
			$contents.="{$error}<br >";
		$contents.="</td></tr></table><br >";
		return $contents;
		}
	}
	
function oks($oks)
	{
	if (!empty($oks))
		{
		$contents="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;' align='center'><tr><td valign='middle' valign='middle'><img src='images/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>	";
		foreach ($oks as $key=>$msg)
			$contents.="{$msg}<br >";
		$contents.="</td></tr></table><br >";
		return $contents;
		}
	}
	
if (!empty($_POST['step'])) $step=$_POST['step'];
else $step='get_contacts';

$ers=array();$oks=array();$import_ok=false;$done=false;
if ($_SERVER['REQUEST_METHOD']=='POST')
	{
	if ($step=='get_contacts')
		{
		if (empty($_POST['email_box']) or empty($_POST['password_box']))
			$ers['email']="Email or Password missing !";
		if (empty($_POST['provider_box']))
			$ers['provider']="Provider missing !";
		if (count($ers)==0)
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal)
				$ers['inviter']=$internal;
			elseif (!$inviter->login($_POST['email_box'],$_POST['password_box']))
				{
				$internal=$inviter->getInternalError();
				$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later !");
				}
			elseif (false===$contacts=$inviter->getMyContacts())
				{
				$ers['contacts']="Unable to get contacts !";
				}
			else
				{
				$import_ok=true;
				$step='send_invites';
				$_POST['oi_session_id']=$inviter->plugin->getSessionID();
				$_POST['message_box']='';
				}
			}
		}
	elseif ($step=='send_invites')
		{
			//echo "here";exit;
		if (empty($_POST['provider_box'])) $ers['provider']='Provider missing !';
		else
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal) $ers['internal']=$internal;
			else
				{
				if (empty($_POST['email_box'])) $ers['inviter']='Inviter information missing !';
				if (empty($_POST['oi_session_id'])) $ers['session_id']='No active session !';
				if (empty($_POST['message_box'])) $ers['message_body']='Message missing !';
				else $_POST['message_box']=strip_tags($_POST['message_box']);
				$selected_contacts=array();$contacts=array();
				$message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"\n\rAttached message: \n\r".$_POST['message_box']);
				if ($inviter->showContacts())
					{
					foreach ($_POST as $key=>$val)
						if (strpos($key,'check_')!==false)
							$selected_contacts[$_POST['email_'.$val]]=$_POST['name_'.$val];
						elseif (strpos($key,'email_')!==false)
							{
							$temp=explode('_',$key);$counter=$temp[1];
							if (is_numeric($temp[1])) $contacts[$val]=$_POST['name_'.$temp[1]];
							}
					if (count($selected_contacts)==0) $ers['contacts']="You haven't selected any contacts to invite !";
					}
				}
			}
		if (count($ers)==0)
			{
				//var_dump($selected_contacts);
				$contents = $selected_contacts;
			$sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$selected_contacts);
			$inviter->logout();
			if ($sendMessage===-1)
				{
				
				$message_subject=$_POST['email_box'].$message['subject'];
				$message_body=$message['body'].$message['attachment'].$message_footer; 
				$headers="From: {$_POST['email_box']}";
				foreach ($selected_contacts as $email=>$name)
					mail($email,$message_subject,$message_body,$headers);
				$oks['mails']="Mails sent successfully";
				}
			elseif ($sendMessage===false)
				{
				$internal=$inviter->getInternalError();
				$ers['internal']=($internal?$internal:"There were errors while sending your invites.<br>Please try again later!");
				}
			else $oks['internal']="Invites sent successfully!";
			$done=true;
			}
		}
	}
else
	{
	$_POST['email_box']='';
	$_POST['password_box']='';
	$_POST['provider_box']='';
	}


if (!$done)
	{
	if ($step=='get_contacts')
		{
			
				$contents ="<form action='' method='POST' name='getcontacts'>".ers($ers).oks($oks);
				$contents.="<table align='center' class='thTable' cellspacing='2' cellpadding='0' style='border:none;'>
					<tr class='thTableRow'><td align='right'><label for='email_box'>Email</label></td><td><input class='thTextbox' type='text' id='email' name='email_box' value='{$_POST['email_box']}'></td></tr>
					<tr class='thTableRow'><td align='right'><label for='password_box'>Password</label></td><td><input class='thTextbox' type='password' id = 'password' name='password_box' value='{$_POST['password_box']}'></td></tr>
					<tr class='thTableRow' style = 'display: none'><td align='right'><label style = 'display: none' for='provider_box'>Email provider</label></td><td><select style = 'display: none' class='thSelect' name='provider_box'><option value=''></option>";
				foreach ($oi_services as $type=>$providers)	
				{
					$contents.="<optgroup label='{$inviter->pluginTypes[$type]}'>";
					foreach ($providers as $provider=>$details)
					$contents.="<option value='{$provider}'".($_POST['provider_box']==$provider?' selected':'').">{$details['name']}</option>";
					$contents.="</optgroup>";
				}
				$contents.="</select></td></tr>
					</table><input type='hidden' name='step' value='get_contacts'>
					<input type='submit' name='submit' style='height: 30px;width:70px; cursor:pointer; border:none; color:#fff; font-weight:bold; margin-left:220px; background:#D52185;background: -webkit-gradient(linear, left top, left bottom, from(#D52185), to(#830046));background: -moz-linear-gradient(top, #D52185, #830046);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#d52185', endColorstr='#830046');padding: 10px;
font-size: 18px;' value='Login' onClick = 'SubmitimportcontactsForm(event);'>";
			
			
		}
	else
	{
		$contents ="<form action = '' name = 'send_invites'>".ers($ers).oks($oks);
		$contents.="<table class='thTable' cellspacing='0' cellpadding='0' style='border:none; width:70%;'>
				<tr class='thTableRow'><td align='right' valign='top'><label for='message_box' style='margin-left: 25px;'>Message</label></td><td><textarea rows='3' cols='50' id ='message_box' name='message_box' class='thTextArea' style='width:390px; height:70px;' >{$_POST['message_box']}</textarea></td></tr>
				
				<input type='hidden' name='step' value='send_invites'>
				<br/>
				<tr class='thTableRow'><td align='center'>
				<input type='submit' name='send_invites' style='height: 30px;width:110px;  cursor:pointer; border:none; color:#fff; font-weight:bold; background:#D52185;background: -webkit-gradient(linear, left top, left bottom, from(#D52185), to(#830046));background: -moz-linear-gradient(top, #D52185, #830046);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#d52185', endColorstr='#830046');padding: 10px;
font-size: 18px;' value='Send Invites' onClick = 'sendinvites(event);'></td></tr>			
				</table>";
	}
	}
//$contents.="<center><a href='http://openinviter.com/'><img src='http://openinviter.com/images/banners/banner_blue_1.gif?nr=80787' border='0' alt='Powered by OpenInviter.com' title='Powered by OpenInviter.com'></a></center>";
if (!$done)
	{
	if ($step=='send_invites')
		{
		if ($inviter->showContacts())
			{
			$contents.="<div style ='overflow :auto; width: 160px;' ><table class='thTable' cellspacing='0' cellpadding='0' width='150'>";
			if (count($contacts)==0)
				$contents.="<tr class='thTableOddRow'><td  style='padding:20px;'>You do not have any contacts in your address book.</td></tr></table>";
			else
				{
				$contents.="<tr class='thTableDesc'><td height='47px'  style='font-weight:bold'><input type='checkbox' id = 'contacts_list' onChange='toggleAll(this)' name='toggle_all' title='Select/Deselect all' checked>Select All</td></tr></table></div><div style ='height:250px; overflow :auto; width: 620px;' ><table class='thTablecontacts' cellspacing='0' cellpadding='0' width='200'>";
				$odd=true;$counter=0;
				foreach ($contacts as $email=>$name)
					{
					$counter++;
					if ($odd) $class='thTableOddRow'; else $class='thTableEvenRow';
					$contents.="<tr class='{$class}'><td width = '5'><input id='check_{$counter}' name='check_{$counter}' value='{$counter}' type='checkbox' class='thCheckbox' checked><input type='hidden' id='email_{$counter}' name='email_{$counter}' value='{$email}'><input type='hidden' id='name_{$counter}' name='name_{$counter}' value='{$name}'></td><td width = '40' text-align = 'right'>{$name}</td>".($plugType == 'email' ?"<td width = '60' text-align = 'right'>{$email}</td>":"")."</tr>";
					$odd=!$odd;
					}
				$contents.="<tr class='thTableFooter'><td style='padding:3px;'></td></tr>";
				}
			$contents.="</table></div>";
			}
		$contents.="<input type='hidden' name='step' value='send_invites'>
		<input type='hidden'  id = 'total_contacts' name='total_contacts' value = ".count($contacts).">
			<input type='hidden' name='provider_box' value='{$_POST['provider_box']}'>
			<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
			<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>";
		}
	}
$contents.="</form>";
//var_dump($contents);
$result["message"] = $contents;

if($step=='send_invites')
{
	$result["type"] = "bar";
}
else
{
	$result["type"] = "modal";
}

echo json_encode(array('result' => $result, 'status' => 'success'));
?>