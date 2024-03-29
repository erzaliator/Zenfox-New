<?php

/**
 * BasePlayerTransaction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $source_id
 * @property integer $player_id
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
 * @property float $base_currency_amount*
 * @property string $base_currency
 * @property integer $frontend_id
 * @property timestamp $trans_start_time
 * @property integer $tracker_id*
 * @property string $notes
 * @property AccountDetail $AccountDetail
 * @property AffiliateTracker $AffiliateTracker
 * @property GameGamegroup $GameGamegroup
 * @property Frontend $Frontend
 * @property Doctrine_Collection $audit_reports
 * @property Doctrine_Collection $affiliate_transactions
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BasePlayerTransaction extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('player_transactions');
        $this->hasColumn('source_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('transaction_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0  => 'AWARD_WINNINGS',
              1  => 'CREDIT_DESPOSITS',
              2  => 'PLACE_WAGER',
              3  => 'CREDIT_BONUS',
              4  => 'WITHDRAWAL_REQUEST',
              5  => 'WITHDRAWAL_FLOWBACK',
//              6  => 'WITHDRAWAL_PARTIAL_FLOWBACK',
              7  => 'WITHDRAWAL_ACCEPT',
//              8  => 'WITHDRAWAL_PARTIAL_ACCEPT',
              9  => 'WITHDRAWAL_REJECT',
//              10 => 'WITHDRAWAL_PARTIAL_REJECT',
              ),
             'notnull' => true,
              ));
        $this->hasColumn('merchant_trans_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('card_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('game_flavour', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('running_machine_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('session_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('gamelog_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
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
        $this->hasColumn('transaction_currency', 'string', 3, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '3',
             ));
        $this->hasColumn('base_currency_amount*', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('base_currency', 'string', 3, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '3',
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('trans_start_time', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('tracker_id*', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('notes', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('AccountDetail', array(
             'local' => 'player_id',
             'foreign' => 'player_id'));

        $this->hasOne('AffiliateTracker', array(
             'local' => 'tracker_id*',
             'foreign' => 'tracker_id'));

        $this->hasOne('GameGamegroup', array(
             'local' => 'game_flavour',
             'foreign' => 'game_flavour'));

        $this->hasOne('Frontend', array(
             'local' => 'frontend_id',
             'foreign' => 'id'));

        $this->hasMany('AuditReport as audit_reports', array(
             'local' => 'source_id',
             'foreign' => 'source_id'));

        $this->hasMany('AffiliateTransaction as affiliate_transactions', array(
             'local' => 'source_id',
             'foreign' => 'source_id'));
    }
}
