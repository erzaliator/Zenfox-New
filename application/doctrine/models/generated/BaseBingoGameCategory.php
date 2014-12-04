<?php

/**
 * BaseBingoGameCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $game_id
 * @property integer $category_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseBingoGameCategory extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('bingo_game_category');
        $this->hasColumn('game_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('category_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
    }

}