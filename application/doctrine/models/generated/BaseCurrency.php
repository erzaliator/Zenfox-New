<?php

/**
 * BaseCurrency
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $currency_code
 * @property string $currency
 * @property string $symbol
 * @property string $currency_description
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseCurrency extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('currency');
        $this->hasColumn('currency_code', 'string', 3, array(
             'type' => 'string',
             'length' => 3,
             'fixed' => true,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('currency', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('symbol', 'string', 5, array(
             'type' => 'string',
             'length' => 5,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('currency_description', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}