<?php

/**
 * BaseCefGamelogArchive
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $game_flavour
 * @property integer $session_Id
 * @property integer $game_id
 * @property string $gamelog
 * @property string $chatlog
 * @property integer $archive_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseCefGamelogArchive extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('cef_gamelog_archive');
        $this->hasColumn('game_flavour', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('session_Id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('game_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('gamelog', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('chatlog', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('archive_id', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
    }

}