<?php 

/**
 * BaseWithdrawalRequest
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $player_id
 * @property integer $withdrawal_id
 * @property integer $child_id
 * @property integer $source_id
 * @property timestamp $datetime
 * @property integer $withdrawal_type
 * @property float $initial_requested   //base curremcy
 * @property float $remaining_amount    //base currency
 * @property integer $csr_id
 * @property integer $amount_type
 * @property float $bonus_bank_change
 * @property float $bonus_winnings_change
 * @property integer $frontend_id
 * @property float $base_currency_amount
 * @property string $base_currency
 * @property float $requested_amount
 * @property string $requested_currency
 * @property integer $processed
 * @property integer $error
 * @property string $notes
 * @property string $csr_notes
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseWithdrawalRequest extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('withdrawal_request');
        $this->hasColumn('player_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => 11,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('withdrawal_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => 11,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('child_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('source_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => 11,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('datetime', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('withdrawal_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
             0 => 'WITHDRAWAL_REQUEST',
             1 => 'WITHDRAWAL_FLOWBACK',
             2 => 'WITHDRAWAL_PARTIAL_FLOWBACK',
             3 => 'WITHDRAWAL_ACCEPT',
             4 => 'WITHDRAWAL_PARTIAL_ACCEPT',
             5 => 'WITHDRAWAL_REJECT',
             6 => 'WITHDRAWAL_PARTIAL_REJECT'
             ),
             ));
        $this->hasColumn('initial_requested', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('remaining_amount', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('csr_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => 11,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('amount_type', 'enum', null, array(
             'type' => 'enum',
             'values' => array(
             0 => 'REAL',      
             1 => 'BONUS'
             ),      
             ));
        $this->hasColumn('bonus_bank_change', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('bonus_winnings_change', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('frontend_id', 'integer', 3, array(
             'type' => 'integer',
             'length' => 3,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('base_currency_amount', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('base_currency', 'string', 3, array(
             'type' => 'string',
             'length' => 3,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('requested_amount', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('requested_currency', 'string', 3, array(
             'type' => 'string',
             'length' => 3,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('processed', 'enum', null, array(
             'type' => 'enum',
             'values' => array(
              0 => 'PROCESSED',
              1 => 'NOT_PROCESSED',
              2 => 'PARTIAL_PROCESSED'     
              ),
             ));
        $this->hasColumn('error', 'enum', null, array(
             'type' => 'enum',
             'values' => array(
             0 => 'NOERROR',
             1 => 'ERROR'     
             ),
             ));
        $this->hasColumn('notes', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('csr_notes', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}