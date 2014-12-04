<?php

/**
 * BaseMobileBonus
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $mobile_bonus_id
 * @property integer $level_id
 * @property integer $gamegroup_id
 * @property float $buddy_bonus
 * @property float $max_buddy_bonus
 * @property float $base_bonus
 * @property integer $level_multiplier
 * @property float $max_bonus
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseMobileBonus extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('mobile_bonus');
        $this->hasColumn('mobile_bonus_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('level_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('gamegroup_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('buddy_bonus', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_buddy_bonus', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('base_bonus', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('level_multiplier', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_bonus', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}