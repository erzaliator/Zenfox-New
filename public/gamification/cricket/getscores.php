<?php
/********* XML2ARRAY Function Start ********/
include_once("../../../library/zendframework/Zend/Debug.php");
include_once("../../../library/Zenfox/Debug.php");
include_once("xml2array.php");

function CricketScores()
{
	
	$jsonObj = NULL;
	
	$url1 = "http://static.cricinfo.com/db/NEW/LIVE/LIVEDATA/WIDGETS/ipl_schedule.xml";

	//print "IPL Schedule";
	$iplSchedule = xml2array($url1);
	//Zenfox_Debug::dump($iplSchedule);
	
	//print $iplSchedule['matches']['match_attr']['id'];
	
	$match_id=$iplSchedule['matches']['match_attr']['id'];
	//$match_id=691449;
	
	$jsonObj['match_id'] = $match_id;
	$dt = new DateTime;
	$jsonObject['servertime'] = $dt->format('Y-m-d H:i:s');
	
	
	$url2 = "http://www.espncricinfo.com/ci/engine/match/gfx/" . $match_id . ".json?template=wagon";
	//print $url2;
    $contents2 = file_get_contents($url2);
    $gResult = json_decode($contents2);
    
    //FIXME:: Rewirte the ifcondition
    if($gResult->t1->n == NULL || $gResult->t2->n == NULL)
    {
    	//print "Display Timer";
    	$jsonObject['status'] ="NOT_STARTED";
    	
    	$jsonObject['t1'] = $iplSchedule['matches']['match']['hometeam_attr']['abbr'];
    	$jsonObject['t2'] = $iplSchedule['matches']['match']['awayteam_attr']['abbr'];
    	
    	$jsonObject['venue'] = $iplSchedule['matches']['match']['venue_attr']['name'];
    	$jsonObject['starttime'] = $iplSchedule['matches']['match_attr']['startdate'] . " " . $iplSchedule['matches']['match']['starttime'];
    	//strtotime($jsonObject['starttime'])
    	$mTime = new DateTime($jsonObject['starttime']);
    	$jsonObject['starttime'] = $mTime->format('Y-m-d H:i:s');
    }
    else 
    {
    	//print "Display Score";
    	$jsonObject['status'] ="STARTED"; //FIXME:: Or Completed
    	$jsonObject['t1'] = substr($gResult->t1->n, 0, 6);
    	$jsonObject['s1'] = $gResult->t1->t;
    	
    	$jsonObject['t2'] = substr($gResult->t2->n,0, 6);
    	$jsonObject['s2'] = $gResult->t2->t;
		$gResult = "";
    	/*
    	print "<pre>";
    	print "Match:: ". $teamName[0] ." vs ". $teamName[1] . "\n";
    	print "Score::\n";
    	print $teamName[0] .": ". $teamScore[0]."\n";
    	print $teamName[1] .": ". $teamScore[1];
    	print "</pre>";
    	*/
    	//Zenfox_Debug::dump($contents2);
    	
    }
    return $jsonObject;
}

$scores = CricketScores();
print json_encode($scores);
?>