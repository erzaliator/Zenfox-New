<?php

abstract class BaseThirdpartyConnect extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('thirdparty_connect');
		$this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
			 'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('parent_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('domain', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('linked', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'YES',
              1 => 'NO',
             ),
             'default' => 'NO',
             ));
	}
} 