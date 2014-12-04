<?php

/**
 * CampaignList
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class CampaignList extends BaseCampaignList
{

	public function startcampaign($groupid , $frontendid ,$type, $templateid , $message , $priority , $now , $campaignname)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		
		$this->type = $type;
		$this->group_id = $groupid;
		$this->frontend_id = $frontendid;
		$this->template_id = $templateid;
		$this->message = $message;
		$this->priority = $priority;
		$this->status = "UNPROCESSED";
		$this->email_req_time = $now;
		$this->campaign_name = $campaignname;
		
		$this->save();
	
		
	}
	
	public function getlastdata($campaignname , $message, $priority)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
		$query = Zenfox_Query::create()
				->from('CampaignList c')
				->where('c.status =?' , "UNPROCESSED")
				->andwhere('c.campaign_name =?' , $campaignname)
				->andwhere('c.priority =?' , $priority)
				->andwhere('c.message =?' , $message);
							
		$result = $query->fetchArray();
		
		return $result[0];
	
	}
	
	
	public function getallcampaign()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
		$query = Zenfox_Query::create()
		->select(' c.status, c.campaign_name , c.priority , c.email_req_time , c.email_sent_time')
		->from('CampaignList c')
		->orderby('c.email_req_time desc');	
			
		$result = $query->fetchArray();
		
		return $result;
	
	}
	
	
}