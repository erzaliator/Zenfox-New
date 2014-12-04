<?php
abstract class BaseEmailTag extends Doctrine_Record
{
	public function setTableDefinition()
	{
		$this->setTableName('email_tag');
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
				'primary' => true,
			));
		$this->hasColumn('query', 'string', null, array(
				'type' => 'string',
			));
	}
}