<?php

/**
 * BaseBingoWinner
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $bingo_gamelog_id
 * @property integer $part_id
 * @property float $real_amount_won
 * @property float $bbs_amount_won
 * @property string $winners
 * @property string $winning_ticket_data
 * @property integer $call_num
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseBingoWinner extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('bingo_winner');
        $this->hasColumn('bingo_gamelog_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('part_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('real_amount_won', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('bbs_amount_won', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('winners', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('winning_ticket_data', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('call_num', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}