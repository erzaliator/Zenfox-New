<?php

/**
 * BasePlayerTransactionRecords
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $transaction_id
 * @property string $gateway_id
 * @property integer $player_id
 * @property string $gateway_trans_id
 * @property float $amount
 * @property string $bank_name
 * @property string $gateway_response
 * @property enum $status
 * @property enum $payment_method
 * @property string $currency_code
 * @property timestamp $trans_start_time
 * @property timestamp $trans_end_time
 * @property timestamp $gateway_trans_time
 * @property string $ip
 * @property string $response_url
 * @property string $request_url
 * @property string $transaction_result
 * @property integer $frontend_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BasePlayerTransactionRecords extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('player_transaction_records');
        $this->hasColumn('transaction_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('gateway_id', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('gateway_trans_id', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('amount', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('bank_name', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('gateway_response', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('status', 'enum', 11, array(
             'type' => 'enum',
             'length' => 11,
             'fixed' => false,
             'values' => 
             array(
              0 => 'PROCESSED',
              1 => 'UNPROCESSED',
              2 => 'PENDING',
              3 => 'ERROR',
              4 => 'CANCELLED',
              5 => 'BACK',
              6 => 'REFRESHED',
             ),
             'primary' => false,
             'default' => 'UNPROCESSED',
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('payment_method', 'enum', 10, array(
             'type' => 'enum',
             'length' => 10,
             'fixed' => false,
             'values' => 
             array(
              0 => 'CREDIT',
              1 => 'DEBIT',
              2 => 'NETBANKING',
              3 => 'MOBILE',
              4 => 'CASH',
              5 => 'MOL',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('currency_code', 'string', 10, array(
             'type' => 'string',
             'length' => 10,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('trans_start_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('trans_end_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('gateway_trans_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('ip', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('response_url', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('request_url', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('transaction_result', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}