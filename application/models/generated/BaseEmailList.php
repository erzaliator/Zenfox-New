<?php
abstract class BaseEmailList extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('email_list');
		$this->hasColumn('id', 'integer', 4, array(
				'type' => 'integer',
				'length' => '4',
				'notnull' => true,
				'primary' => true,
				'autoincrement' => true,
			));
		$this->hasColumn('name', 'string', 45, array(
				'type' => 'string',
				'length' => '45',
				'notnull' => true,
				'unique' => true,
			));
		$this->hasColumn('function', 'string', null, array(
				'type' => 'string',
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
	}
	
	public function setUp()
	{
		$this->hasMany('MailLog as mail_log', array(
				'local' => 'id',
				'foreign' => 'id'));
	}
}