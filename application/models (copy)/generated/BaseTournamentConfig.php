<?php

/**
 * BaseTournamentConfig
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $tournament_config_id
 * @property string $tournament_type
 * @property string $tournament_config_name
 * @property string $description
 * @property string $config
 * @property float $initial_tournament_chips
 * @property string $registration_cost
 * @property string $rewards
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseTournamentConfig extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('tournament_config');
        $this->hasColumn('tournament_config_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('tournament_type', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('tournament_config_name', 'string', 40, array(
             'type' => 'string',
             'length' => 40,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('description', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('config', 'string', 5000, array(
             'type' => 'string',
             'length' => 5000,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('initial_tournament_chips', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'default' => '4000',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('registration_cost', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             'fixed' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('rewards', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             'fixed' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

}