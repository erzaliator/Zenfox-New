<?php

/**
 * BaseBingoConfig
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $variable
 * @property string $value
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseBingoConfig extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('bingo_config');
        $this->hasColumn('variable', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('value', 'string', 1024, array(
             'type' => 'string',
             'length' => 1024,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}