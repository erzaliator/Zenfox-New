<?php

abstract class BasePlayerTransactionRecord extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('player_transaction_records');
		$this->hasColumn('transaction_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
			 'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('gateway_id', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
        	 'notnull' => true,
             ));
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('gateway_trans_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
        	 'unique' => true,
             ));
        $this->hasColumn('amount', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('bank_name', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('gateway_response', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'PROCESSED',
              1 => 'UNPROCESSED',
              2 => 'PENDING',
        	  3 => 'ERROR',
             ),
             'default' => 'UNPROCESSED',
             ));
        $this->hasColumn('payment_method', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'CREDIT',
              1 => 'DEBIT',
              2 => 'NETBANKING',
              3 => 'MOBILE',
              4 => 'CASH',
        	  5 => 'MOL',
             ),
             ));
        $this->hasColumn('currency_code', 'string', 3, array(
             'type' => 'string',
             'length' => '3',
             'notnull' => true,
             ));
        $this->hasColumn('trans_start_time', 'timestamp', null, array(
				'type' => 'timestamp',
				));
        $this->hasColumn('trans_end_time', 'timestamp', null, array(
				'type' => 'timestamp',
				));
		$this->hasColumn('gateway_trans_time', 'timestamp', null, array(
				'type' => 'timestamp',
				));
		$this->hasColumn('ip', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('request_url', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('response_url', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
      /*  $this->hasColumn('transaction_result', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));*/
	}
}