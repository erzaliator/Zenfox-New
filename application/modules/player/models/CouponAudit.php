<?php
class CouponAudit extends BaseCouponAudit
{
	public function insert($data)
	{
		$today = new Zend_Date();
        $startTime = $today->get(Zend_Date::W3C);

		$this->player_id = $data['playerId'];
		$this->frontend_id = Zend_Registry::get('frontendId');
		$this->coupon_code = $data['couponCode'];
		$this->coupon_id = $data['couponId'];
		$this->coupon_type = $data['couponType'];
		$this->amount = $data['amount'];
		$this->amount_type = $data['amountType'];
		$this->transaction_start_time = $startTime;
		$this->max_redeem_times = $data['maxRedeemTimes'];
		$this->remaining_redeems = $data['remainingRedeems'];
		$this->redeemed_times = $data['redeemedTimes'];
		$this->status = 'PROCESSING';
		$this->error = 'NO_ERROR';
		try
		{
			$this->save();
		}
		catch(Exception $e)
		{
			return false;
		}
		
		$query = Zenfox_Query::create()
					->from('CouponAuDit c')
					->where('c.player_id = ?', $data['playerId'])
					->orderBy('c.coupon_audit_id DESC')
					->limit(1);
					
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}

		return array(
			'couponAuditId' => $result[0]['coupon_audit_id'],
			'amount' => $result[0]['amount'],
			'remainingRedeems' => $result[0]['remaining_redeems'],
			'redeemedTimes' => $result[0]['redeemed_times'],
		);
	}
	
	public function update($data, $couponAuditId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($data['playerId']);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$today = new Zend_Date();
        $endTime = $today->get(Zend_Date::W3C);
		
		$query = Zenfox_Query::create()
					->update('CouponAudit c')
					->set('c.redeemed_times', '?', $data['redeemedTimes'])
					->set('c.remaining_redeems', '?', $data['remainingRedeems'])
					->set('c.audit_id', '?', $data['auditId'])
					->set('c.source_id', '?', $data['sourceId'])
					->set('c.transaction_end_time', '?', $endTime)
					->set('c.status', '?', 'PROCESSED')
					->where('c.coupon_audit_id = ?', $couponAuditId);
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			return false;
		}
	}
}