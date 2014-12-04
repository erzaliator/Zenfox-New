<?php

abstract class BasePlayerCardDetail extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('player_card_details');
		$this->hasColumn('id', 'integer', 4, array(
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
        $this->hasColumn('card_no', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
        	 'unique' => true,
             'notnull' => true,
             ));
        $this->hasColumn('card_holder_first_name', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             'notnull' => true,
             ));
        $this->hasColumn('card_holder_middle_name', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             'notnull' => true,
             ));
        $this->hasColumn('card_holder_last_name', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             'notnull' => true,
             ));
        $this->hasColumn('card_holder_address', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             'notnull' => true,
             ));
        $this->hasColumn('card_holder_city', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             'notnull' => true,
             ));
        $this->hasColumn('card_holder_state', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             'notnull' => true,
             ));
        $this->hasColumn('card_holder_zip', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             'notnull' => true,
             ));
        $this->hasColumn('card_holder_country', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             'notnull' => true,
             ));
        $this->hasColumn('card_subtype', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'VISA',
              1 => 'MASTER',
              2 => 'CASH',
             ),
             ));
        $this->hasColumn('card_expiry_month', 'integer', 2, array(
             'type' => 'integer',
             'length' => '2',
             'notnull' => true,
             ));
        $this->hasColumn('card_expiry_year', 'integer', 2, array(
             'type' => 'integer',
             'length' => '2',
             'notnull' => true,
             ));
        $this->hasColumn('card_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'CREDIT',
              1 => 'DEBIT',
              2 => 'CASH',
             ),
             ));
	}
}