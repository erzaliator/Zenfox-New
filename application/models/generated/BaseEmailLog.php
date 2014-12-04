<?php
abstract class BaseEmailLog extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('email_log');
		$this->hasColumn('id', 'integer', 4, array(
				'type' => 'integer',
				'length' => '4',
				'notnull' => true,
				'primary' => true,
				'autoincrement' => true,
			));
		$this->hasColumn('list_id', 'integer', 4, array(
				'type' => 'integer',
				'length' => '4',
				'notnull' => true,
				'primary' => true,
			));
		$this->hasColumn('template_id', 'integer', 4, array(
				'type' => 'integer',
				'length' => '4',
				'notnull' => true,
				'primary' => true,
			));
		$this->hasColumn('language', 'enum', null, array(
				'type' => 'enum',
				'values' =>
				array(
					0 => 'PHP',
					1 => 'PYTHON',
					2 => 'JAVA',
				),
			));
		$this->hasColumn('frontend_id', 'integer', 4, array(
				'type' => 'integer',
				'length' => '4',
			));
		$this->hasColumn('status', 'enum', null, array(
				'type' => 'enum',
				'values' => 
				array(
					'0' => 'PROCESSED',
					'1' => 'UNPROCESSED',
				),
				'default' => 'UNPROCESSED',
			));
		$this->hasColumn('error', 'enum', null, array(
				'type' => 'enum',
				'values' =>
				array(
					0 => 'ERROR',
					1 => 'NO_ERROR'
				),
			));
		$this->hasColumn('args', 'string', 255, array(
				'type' => 'string',
				'length' => '255',
			));
		$this->hasColumn('notes', 'string', 255, array(
				'type' => 'string',
				'length' => '255',
			));
	}
	
	public function setUp()
	{
		$this->hasOne('Lists as list', array(
				'local' => 'list_id',
				'foreign' => 'id'));
		
		$this->hasOne('Email as email', array(
				'local' => 'template_id',
				'foreign' => 'id'));
	}
}