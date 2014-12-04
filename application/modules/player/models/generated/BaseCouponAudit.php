<?php

/**
 * BaseAuditReport
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $audit_id
 * @property integer $player_id
 * @property integer $source_id
 * @property enum $transaction_type
 * @property integer $merchant_trans_id
 * @property integer $card_id
 * @property string $game_flavour
 * @property integer $running_machine_id
 * @property integer $session_id
 * @property integer $gamelog_id
 * @property float $amount
 * @property enum $amount_type
 * @property string $transaction_currency
 * @property float $base_currency_amount
 * @property string $base_currency
 * @property enum $transaction_status
 * @property string $notes
 * @property integer $frontend_id
 * @property timestamp $trans_start_time
 * @property timestamp $trans_end_time
 * @property integer $parent_id
 * @property enum $processed
 * @property enum $error
 * @property float $cash_balance
 * @property float $bb_balance
 * @property float $real_change
 * @property float $bonus_change
 * @property integer $tracker_id
 * @property float $conversion_rate
 * @property float $converted_amount
 * @property integer $bonus_scheme_id
 * @property integer $bonus_level_id
 * @property float $loyalty_points_left
 * @property float $total_loyalty_points
 * @property PlayerTransaction $PlayerTransaction
 * @property AffiliateTracker $AffiliateTracker
 * @property GameGamegroup $GameGamegroup
 * @property BonusLevel $BonusLevel
 * @property Frontend $Frontend
 * @property BonusScheme $BonusScheme
 * @property Doctrine_Collection $affiliate_transactions
 * @property Doctrine_Collection $ticket_sales
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseCouponAudit extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('coupon_audit');
        $this->hasColumn('coupon_audit_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
        	 'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
        	 'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('coupon_code', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('coupon_id', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('coupon_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'FREE_BONUS',
              1 => 'DEPOSIT_BONUS',
             ),
             ));
        $this->hasColumn('amount', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('amount_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'REAL',
              1 => 'BONUS',
              2 => 'BOTH',
             ),
             ));
        $this->hasColumn('currency', 'string', 3, array(
             'type' => 'string',
          	 'length' => '3',
             ));
        $this->hasColumn('transaction_start_time', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('max_redeem_times', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('redeemed_times', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('remaining_redeems', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             )); 
        $this->hasColumn('total_redeemed_real', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('total_redeemed_bbs', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('transaction_end_time', 'timestamp', null, array(
             'type' => 'timestamp',
             ));             
        $this->hasColumn('audit_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('source_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'PROCESSED',
              1 => 'NOT_PROCESSED',
              2 => 'PROCESSING',
             ),
             ));
        $this->hasColumn('error', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ERROR',
              1 => 'NO_ERROR',
             ),
             ));            
        $this->hasColumn('notes', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('csr_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->option('type', 'MyISAM');
    }
}