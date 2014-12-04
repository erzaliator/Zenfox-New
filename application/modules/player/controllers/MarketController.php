<?php

class Player_MarketController extends Zenfox_Controller_Action
{
	public function init()
	{
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('item', 'json')
		->addActionContext('index','json')
		->addActionContext('buy','json')
		->addActionContext('sell','json')
		->addActionContext('use','json')
		->initContext();
	}


	public function indexAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];

		
		
		if(isset($playerId))
		{
			$playerInventory = new PlayerInventory();
			$playerInventory->cleanInventory($playerId);

			$itemCount=0;
			$marketItems = new MarketItems();
			$marketItemCategories = new MarketItemCategories();
			$result = $playerInventory->getDataByPlayerId($playerId);
			if($result)
			{
				foreach($result as $data)
				{
					
					$itemProperties = $marketItems->getDataByItemId($data['itemId']);
					$categoryName = $marketItemCategories->getDataByCategoryId($itemProperties['categoryId']);	
					$itemJsonArray[$itemCount++] = array(
								'inventoryId' 		=> $data['inventoryId'], 
								'expiry' 			=> $data['expiry'],
								'itemId'			=> $data['itemId'],
								'name'				=> $itemProperties['name'],
								'description'		=> $itemProperties['description'],								
								'buyPrice'     		=> $itemProperties['buyPrice'],
								'sellPrice'			=> $itemProperties['sellPrice'],
								'giftPrice'			=> $itemProperties['giftPrice'],
								'buyPoints'			=> $itemProperties['buyPoints'],
								'sellPoints'  		=> $itemProperties['sellPoints'],
								'giftPoints'		=> $itemProperties['giftPoints'],
								'periodOfAvailability' => $itemProperties['periodOfAvailability'],
								'swf'				=> $itemProperties['swf'],
								'json'				=> $itemProperties['json'],
								'identifier'		=> $itemProperties['identifier'],
								'categoryName'		=> $categoryName			
					);
				}
				$this->view->data = array(
							'message'		=> $itemCount." Items in your inventory",
							'success'		=> TRUE,
							'item_obj'		=> $itemJsonArray
				);				
			}
			else
			{
				$this->view->data = array(
							'message'		=> "No items in inventory",
							'success'		=> TRUE,
							'item_obj'		=> NULL
				);
			}
		}
		else
		{
			$this->view->data = array(
							'message'		=> "User not logged in",
							'success'		=> FALSE,
							'item_obj'		=> NULL
				);
		}


	}

	public function buyAction()
	{
		if($this->_request->isPost())
		{
			$itemId = $this->_request->getParam("itemId");

			$session = new Zenfox_Auth_Storage_Session();
			$store = $session->read();
			$playerId = $store['id'];
			
			$success=FALSE;
			$itemObj=NULL;
			$inventoryId = NULL;
				
			if(isset($playerId))
			{
				$marketItems = new MarketItems();
				$returnArray = $marketItems->getDataByItemId($itemId);

				$inventorySize = $returnArray['inventorySize'];
				$buyPrice =  $returnArray['buyPrice'];
				$periodOfAvailability = $returnArray['periodOfAvailability'];
				$itemName = $returnArray['name'];
				if($inventorySize>0)
				{
					$accDetails = new AccountDetail();
					$returnArray1 = $accDetails->getData($playerId);

					$balance = $returnArray1['balance'];
					
					if($balance>=$buyPrice)
					{
						$playerTransactions = new PlayerTransactions();

						$sourceId=$playerTransactions->buyMarketItemTransaction($playerId,$buyPrice);

						if(isset($sourceId))
						{
							$auditReport = new AuditReport();
							$auditResult = $auditReport->checkError($sourceId,$playerId);	
							if($auditResult['error']=="NOERROR")
							{
								$marketItems->updateInventorySize($itemId,$inventorySize-1);

								$hr = (int)($periodOfAvailability / 60) ;
								$min = $periodOfAvailability % 60 ;

								$expiryDate = mktime(date("H")+$hr, date("i")+$min, date("s"), date("m"), date("d"), date("y"));
								$expiry= date("y-m-d H:i:s", $expiryDate);

								$json['in_use'] = "true";
								$jsonData = Zend_Json::encode($json);
								$playerInventory = new PlayerInventory();
								$playerInventory->insert($playerId,$itemId,$expiry, $jsonData);
								$inventoryId = $playerInventory->getLatestInventoryId($playerId, $itemId);

								$message="You just bought ".$itemName;
								$success=TRUE;
								$itemObj=$returnArray;
							}
							else
							{
								$message="Error while transaction in audit Report";
							}
						}
						else
						{
							$message="Transaction never started";
						}
					}
					else
					{
						$message="Not sufficient balance in users account";
					}
				}
				else
				{
					$message = "Market Inventory is empty";
				}
			}
			else
			{
				$message = "User not logged in";
			}
			$this->view->data = array(
							'message'		=> $message,
							'success'		=> $success,
							'item_obj'		=> $itemObj,
							'player_id'		=> $playerId,
							'inventory_id'	=> $inventoryId
			);

		}

	}
	public function sellAction()
	{
		if($this->_request->isPost())
		{
			$itemId = $this->_request->getParam("itemId");

			$session = new Zenfox_Auth_Storage_Session();
			$store = $session->read();
			$playerId = $store['id'];

			
			$success=FALSE;
			$itemObj=NULL;
			if(isset($playerId))
			{
				$marketItems = new MarketItems();
				$returnArray = $marketItems->getDataByItemId($itemId);

				$sellPrice =  $returnArray['sellPrice'];
				$inventorySize = $returnArray['inventorySize'];
				$itemName = $returnArray['name'];

				$playerInventory = new PlayerInventory();
				$playerInventory->cleanInventory($playerId);


				$result = $playerInventory->getData($playerId,$itemId);
				$inventoryId = $result[0]['inventoryId'];
				if(isset($inventoryId))
				{
					$playerTransactions = new PlayerTransactions();
					$sourceId=$playerTransactions->sellMarketItemTransaction($playerId, $sellPrice);

					if(isset($sourceId))
					{
						$auditReport = new AuditReport();
						$auditResult = $auditReport->checkError($sourceId,$playerId);
							
						if($auditResult['error']=="NOERROR")
						{
							$playerInventory->delete($playerId,$inventoryId);
							$marketItems->updateInventorySize($itemId,$inventorySize+1);

							$message="You just sold ".$itemName;
							$success=TRUE;
							$itemObj=$returnArray;
						}
						else
						{
							$message = "Error while transaction in audit Report";
						}
					}
					else
					{
						$message = "Transaction failed";
					}
				}
				else
				{
					$message = "No item to sell in your personal inventory";
				}
			}
			else
			{
				$message = "Please log in first";
			}
			$this->view->data = array(
							'message'		=> $message,
							'success'		=> $success,
							'item_obj'		=> $itemObj
			);
		}

	}
	public function giftAction()
	{

	}

	public function itemAction()
	{
		$marketItems = new MarketItems();
		$marketItemCategories = new MarketItemCategories();

		$categoryCount=0;
		$categoryArray=$marketItemCategories->getData();

		foreach($categoryArray as $category)
		{
			$itemCount=0;
			$itemJsonArray= NULL;
			$itemArray= NULL;

			$itemArray = $marketItems->getDataByCategoryId($category['categoryId']);
			foreach($itemArray as $item)
			{
				if($item['enabled']=="TRUE")
				{
					$propertiesJsonArray = json_decode($item['json']);
					$itemJsonArray[$itemCount++] = array(
								'id' 		=> $item['itemId'],								 
								'name' 		=> $item['name'],
								'price'     => $item['buyPrice'],
								'image_url' => $item['swf'],								
								'lifetime'	=> $item['periodOfAvailability'],							
								'properties'=> $propertiesJsonArray,
								'identifier'=> $item['identifier']								
					);
				}

			}


			$categoryJsonArray[$categoryCount++] = array(
							'name'      => $category['name'],
							'items'		=> $itemJsonArray
			);
		}
		$this->view->data = $categoryJsonArray;
	}
	
	public function useAction()
	{
		if($this->_request->isPost())
		{
			$currentInventoryId = $this->_request->getParam('currentInventoryId');
			$prevInventoryId = $this->_request->getParam('prevInventoryId');
			
			$session = new Zenfox_Auth_Storage_Session();
			$storedData = $session->read();
			$playerId = $storedData['id'];
			
			$playerInventory = new PlayerInventory();
			$playerInventory->changeUseStatusToFalse($playerId, $prevInventoryId);
			$playerInventory->changeUseStatusToTrue($playerId, $currentInventoryId);
		}
	}

}