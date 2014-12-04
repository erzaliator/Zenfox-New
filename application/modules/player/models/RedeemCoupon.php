<?php
class RedeemCoupon
{
	public function redeem($playerId, $code, $baseCurrency)
	{	
		$bonusCoupon = new BonusCoupons();
		//$couponData = $bonusCoupon->getBonusCouponData($code, $playerId);
		
		$couponData = $bonusCoupon->getBonusCouponData($code);

		if(!$couponData)
		{
			return array(
				'error' => true,
				'message' => "This is not a valid coupon. Would you like to enter another one?");
			//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("This coupon is already redeemed. Would you like to enter another one?")));
			//$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/home';
		}
		elseif($couponData[0]['status'] == 'REDEEMED')
		{
			return array(
				'error' => true,
				'message' => "This coupon is already redeemed. Would you like to enter another one?");
		}
		elseif(isset($couponData))
		{
			$data['playerId'] = $playerId;
			$data['couponCode'] = $couponData[0]['coupon_code'];
			$data['couponId'] = $couponData[0]['id'];
			$data['couponType'] = $couponData[0]['code_type'];
			$data['amount'] = $couponData[0]['amount'];
			$data['amountType'] = $couponData[0]['amount_type'];
			$data['maxRedeemTimes'] = $couponData[0]['max_redeem_times'];
			$data['remainingRedeems'] = $couponData[0]['remaining_redeems'];
			$data['redeemedTimes'] = $couponData[0]['redeemed_times'];
		
			//FIXME Remove it from here
			$conn = Zenfox_Partition::getInstance()->getConnections($data['playerId']);
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
			$couponAudit = new CouponAudit();
			$couponAuditData = $couponAudit->insert($data);
		
			$couponAuditId = $couponAuditData['couponAuditId'];
			$couponAmount = $couponAuditData['amount'];
			$remainingRedeems = $couponAuditData['remainingRedeems'];
			$redeemedTimes = $couponAuditData['redeemedTimes'];
		
			$playerTransaction = new PlayerTransactions();
			$sourceId = $playerTransaction->creditBonus($playerId, $couponAmount, $baseCurrency, 'Rakhi Gift');
			if(!$sourceId)
			{
				return array(
					'error' => true,
					'message' => "Could not credit bonus.");
				//$this->_helper->FlashMessenger(array('error' => 'Could not credit bonus.'));
			}
			$auditReport = new AuditReport();
			$reportMessage = $auditReport->checkError($sourceId, $playerId);
				
			$counter = 0;
			while((!($reportMessage['processed'] == 'PROCESSED')) && (!($reportMessage['error'] == 'NOERROR')))
			{
				if($counter == 3)
				{
					break;
				}
				$reportMessage = $auditReport->checkError($sourceId, $playerId);
				if($reportMessage)
				{
					break;
				}
				$counter++;
			}
			if($counter == 3 && !$reportMessage)
			{
				return array(
					'error' => true,
					'message' => "Your amount has not been credited, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>");
				//$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your amount has not been credited, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>" )));
			}
			if(($reportMessage['processed'] == 'PROCESSED') && ($reportMessage['error'] == 'NOERROR'))
			{
				$redeemedTimes++;
				$remainingRedeems--;
				$data['redeemedTimes'] = $redeemedTimes;
				$data['remainingRedeems'] = $remainingRedeems;
				$data['auditId'] = $reportMessage['auditId'];
				$data['sourceId'] = $sourceId;
				$couponAudit->update($data, $couponAuditId);
			}
			$couponData[0]['redeemed_times']++;
			$couponData[0]['remaining_redeems']--;
			if(($couponData[0]['max_redeem_times'] == $couponData[0]['redeemed_times']) || ($couponData[0]['remaining_redeems'] == 0))
			{
				$status = 'REDEEMED';
			}
			else
			{
				$status = 'VALID';
			}
			$coupon = new Coupons();
			$coupon->update($code, $status, $couponData[0]);
			
			$player = new Player();
			$playerData = $player->getAccountDetails($playerId);
			
			if($playerData[0]['total_deposits'] == 0)
			{
				$updateData['noof_deposits'] = 1;
				$updateData['total_deposits'] = 100;
				$player->updateAccountDetails($updateData, $playerId);
			}
			
			return array(
				'error' => false,
				'message' => "Congratulations!! Your account has been credited.");
			//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Congratulations!! Your account has been credited. You will be redirected to the games page.")));
		}
	}
	
	public function generateCoupon($playerId, $data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$master = Doctrine_Manager::getInstance()->getConnection($conn);

		$bonusCoupons = new BonusCoupons();
		$bonusCoupons->coupon_code = $data['code'];
		$bonusCoupons->code_type = 'FREE_BONUS';
		$bonusCoupons->amount = 100;
		$bonusCoupons->amount_type = 'BONUS';
		$bonusCoupons->currency = 'INR';
		$bonusCoupons->max_redeem_times = 1;
		$bonusCoupons->redeemed_times = 0;
		$bonusCoupons->remaining_redeems = 1;
		$bonusCoupons->player_id = $playerId;
		$bonusCoupons->frontend_id = 1;
		$bonusCoupons->status = 'VALID';
		
		try
		{
			$bonusCoupons->save($master);
		}
		catch(Exception $e)
		{
			//Zenfox_Debug::dump($e, 'e', true, true);
		}
	}
}