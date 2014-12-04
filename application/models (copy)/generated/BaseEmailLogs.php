<?php
abstract class BaseEmailLogs extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('email_logs');
		$this->hasColumn('user_id', 'integer', 4, array(
				'type' => 'integer',
				'length' => 4,
				'notnull' => true,
				'primary' => true
			));
			
		$this->hasColumn('user_type', 'enum', null, array(
				'type' => 'enum',
				'values' => array(
					'0' => 'PLAYER',
					'1' => 'AFFILIATE',
					'2' => 'ADMIN'
				),
				'default' => 'PLAYER'
			));
			
		$this->hasColumn('email_list', 'string', null, array(
				'type' => 'string'
			));
			
		$this->hasColumn('last_updated', 'date', null, array(
				'type' => 'date'
			));
			
		$this->hasColumn('status', 'string', 45, array(
				'type' => 'string',
				'length' => 45
			));
			
		$this->hasColumn('message', 'string', 45, array(
				'type' => 'string',
				'length' => 45
			));
			
		$this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
	}
}