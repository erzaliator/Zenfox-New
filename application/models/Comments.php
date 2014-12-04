<?php
class Comments extends BaseComments
{
	public function insertData($data)
	{		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$date = new Zend_Date();
		$today = $date->get(Zend_Date::W3C);

		$this->user_name = $data['userName'];
		$this->page_address = $data['page'];
		//FIXME change according to the page
		$this->topic = 'Web Site';
		$this->comment = $data['comment'];
		$this->email = $data['email'];
		$this->post_time = $today;
		try
		{
			$this->save();
		}
		catch(Exception $e)
		{
			return false;
		}
		return true;
	}
	
	public function getAllComments($offset, $itemsPerPage)
	{
		$query = "Zenfox_Query::create()
						->from('Comments c')
						->orderby('c.post_time desc')";
		
		$result = $this->getPaginator($query, $offset, $itemsPerPage);
		return $result;
	}
	
	public function searchByFields($searchingFields, $from, $to, $offset, $itemsPerPage)
	{
		/*if($searchingFields['pageAddress'] && $searchingFields['topic'] && $searchingFields['userName'])
		{
			echo "here";
		}*/
		$countFields = count($searchingFields);
		$counter = 0;
		$query = "Zenfox_Query::create()
						->from('Comments c')
						->where('c.post_time BETWEEN ? AND ?', array('$from', '$to'))
						->orderby('c.post_time desc')";
		if($searchingFields)
		{
			foreach($searchingFields as $index => $value)
			{
				if($counter != $countFields)
				{
					$query = $query . "->andWhere('c.$index = ?', '$value')";
					$counter++;
				}
			}
		}
		$result = $this->getPaginator($query, $offset, $itemsPerPage);
		return $result;
	}
	
	public function getCommentsByField($index, $field, $offset, $itemsPerPage)
	{
		$query = "Zenfox_Query::create()
							->from('Comments c')
							->where('c.$index = ?', '$field')
							->orderby('c.post_time desc')";
		
		$result = $this->getPaginator($query, $offset, $itemsPerPage);
		return $result;
	}
	
	public function getPaginator($query, $offset, $itemsPerPage)
	{
		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
		$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
		$paginator = new Zend_Paginator($adapter);
		$paginator->setCurrentPageNumber($offset);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
			
		if($paginator->getTotalItemCount())
		{
			$commentData = array();
			$index = 0;
			foreach($paginator as $comments)
			{
				$commentData[$index]['Date'] = $comments['post_time'];
				$commentData[$index]['Comment'] = $comments['comment'];
				$commentData[$index]['Page Address'] = $comments['page_address'];
				$commentData[$index]['User Name'] = $comments['user_name'];
				$commentData[$index]['Topic'] = $comments['topic'];
				$commentData[$index]['User Email Id'] = $comments['email'];
				$commentData[$index]['Current Status'] = $comments['enabled'];
				$commentData[$index]['Change Status'] = $comments['id'];
				$index++;
			}
			$paginatorSession->unsetAll();
			return array(
					'paginator' => $paginator, 
					'content' => $commentData
				);
		}
		else
		{
			return NULL;
		}
	}
	
	
	public function changeStatus($commentId, $newStatus)
	{
		/* if($currentStatus == 'ENABLED')
		{
			$newStatus = 'DISABLED';
		}
		else
		{
			$newStatus = 'ENABLED';
		} */

		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->update('Comments c')
						->set('c.enabled', '?', $newStatus)
						->where('c.id = ?', $commentId);
						
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			return false;
		}
		return true;
	}
	
	public function getCommentsByPage($pageAddress, $offset, $itemsPerPage)
	{
		$query = "Zenfox_Query::create()
							->select('c.user_name, c.comment, c.post_time')
							->from('Comments c')
							->where('c.page_address = ?', '$pageAddress')
							->orderby('c.post_time desc')";
		
		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
		$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setCurrentPageNumber($offset);
		$paginator->setPageRange(2);
		$index = 0;
		$commentData = array();
		if($paginator->getTotalItemCount())
		{
			foreach($paginator as $comment)
			{
				$commentData[$index]['Posted'] = $comment['post_time'];
				$commentData[$index]['User Name'] = $comment['user_name'];
				$commentData[$index]['Comment'] = $comment['comment'];
				$index++;
			}
			$paginatorSession->unsetAll();
			return array(
				'paginator' => $paginator,
				'content' => $commentData,
			);
		}
		return NULL;
	}
	
	public function getTestimonials()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Comments c')
					->where('c.page_address = ?', 'player-testimonial-index')
					->andWhere('c.enabled = ?', 'ENABLED')
					->orderby('c.id DESC')
					->limit(5);
					
		$result = $query->fetchArray();
		//Zenfox_Debug::dump($result, 'result');
		return $result;
	}
	
	public function getAllTestimonials($offset, $itemsPerPage, $userType = NULL)
	{
		
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
        $csrfrontendids = $sessionData["frontend_ids"];
        
		$query = "Zenfox_Query::create()
							->from('Comments c')
							->where('c.page_address = ?', 'player-testimonial-index')";
		
		if(!$userType)
		{
			$query = $query . "->andWhere('c.enabled = ?', 'ENABLED')";
		}
		$query = $query . "->orderby('c.id desc')";
		
		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
		$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setCurrentPageNumber($offset);
		$paginator->setPageRange(2);
		$index = 0;
		$testimonialsData = array();
		$player = new Player();
		if($paginator->getTotalItemCount())
		{
			foreach($paginator as $testimonial)
			{
				$playerDetail = $player->getAccountIdFromLogin($testimonial['user_name']);
				$playerId = $playerDetail['player_id'];

				$accountDetails = $player->getPlayerData($playerId);
				$frontendid = $player->getfrontendidofplayer($playerId);
				//if(in_array($frontendid,$csrfrontendids))
				//{
					$name = empty($firstName)?$testimonial['user_name']:$firstName;
					if($userType)
					{
						$testimonialsData[$index]['id'] = $testimonial['id'];
					}
					$firstName = $accountDetails['firstName'];
					$name = empty($firstName)?$testimonial['user_name']:$firstName;
					if($userType)
					{
						$testimonialsData[$index]['id'] = $testimonial['id'];
					}
					$testimonialsData[$index]['playerId'] = $playerId;
					$testimonialsData[$index]['name'] = $name;
					$testimonialsData[$index]['testi'] = $testimonial['comment'];
					if($userType)
					{
						switch($testimonial['enabled'])
						{
							case 'ENABLED':
								$status = 'DISABLED';
								break;
							case 'DISABLED':
								$status = 'ENABLED';
								break;
						}
					
						$form = '<form action="/testimonial/index/id/' . $testimonial['id'] . '" method = "POST"><input type="submit" name="status" value="' . $status . '"></form>';
						$testimonialsData[$index]['status'] = $testimonial['enabled'] . $form;
					}
					$index++;
				//}
				
				
			}
			$paginatorSession->unsetAll();
			return array(
				'paginator' => $paginator,
				'content' => $testimonialsData,
			);
		}
		return NULL;		
	}
	
	public function getTestiById($testimonialId , $getall = null)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Comments c')
					->where('c.id = ?', $testimonialId);
		
		try
		{
			$testiData = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return NULL;
		}
		if($getall)
		{
			return $testiData[0];
		}
		return array(
			'comment' => $testiData[0]['comment'],
			'status' => $testiData[0]['enabled']
		);
	}
	
	public function editTestiById($testimonialId, $comment, $status)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->update('Comments c')
					->set('c.comment', '?', $comment)
					->set('c.enabled', '?', $status)
					->where('c.id = ?', $testimonialId);
		
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'exception', true, true);
		}
		return true;
	}
}
