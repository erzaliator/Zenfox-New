<?php

//Uncomment these lines for debugging purposes
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 'On');
require_once 'includes/ttw.notification.center.php';
//inlude the notification center class

$playerid = $_GET['player_id'];

if($playerid%2 == 0)
{
	$db_host = "zenfox-slave1:3306";
}
else
{
	$db_host = "zenfox-slave2:3306";
}
	$db_user = "zenfox-web";
	$db_password = "e6e3be2d833cdf5d9d4c7bc2f85cd098";
	$db_name = "gamify";

//create an instance of the notification center
$notifications = new NotificationCenter($db_host, $db_user, $db_password, $db_name,$playerid);


/*
 * 
 * http://taashtime.tld/gamification/sampleHandler.php/command/get/category/test/read_status/true/
 * 
 * http://taashtime.tld/gamification/sampleHandler.php?command=get&category=test&read_status=true
 * 
 * 
 */



//process each command
switch ($_GET['command'])
{
    case 'update':
        return $notifications->update_notificationstatus($_GET['messageid']);
        break;
    case 'get':
        $value = $notifications->get($_GET['category'], $_GET['read_status']);
        //print_r($value);
        return $value;
        break;
    case 'get_new':
         $value = $notifications->get_new();
         return $value ;
         break;
     case 'delete':
        // return $notifications->delete_notification($_GET['id']);
         break;
    default:
        break;
}
