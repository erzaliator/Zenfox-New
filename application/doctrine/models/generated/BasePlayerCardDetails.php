<?php

/**
 * BasePlayerCardDetails
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $player_id
 * @property string $card_no
 * @property string $card_holder_first_name
 * @property string $card_holder_last_name
 * @property string $card_holder_address
 * @property string $card_holder_city
 * @property string $card_holder_state
 * @property string $card_holder_zip
 * @property string $card_holder_country
 * @property string $card_holder_ip
 * @property enum $card_type
 * @property enum $card_subtype
 * @property string $card_expiry_year
 * @property string $card_expiry_month
 * @property string $card_access_token
 * @property string $card_issue_number
 * @property string $card_cvc_no
 * @property string $card_valid_month
 * @property string $card_valid_year
 * @property enum $enabled
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BasePlayerCardDetails extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('player_card_details');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_no', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_holder_first_name', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_holder_last_name', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_holder_address', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_holder_city', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_holder_state', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_holder_zip', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_holder_country', 'string', 2, array(
             'type' => 'string',
             'length' => 2,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_holder_ip', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_type', 'enum', 6, array(
             'type' => 'enum',
             'length' => 6,
             'fixed' => false,
             'values' => 
             array(
              0 => 'CREDIT',
              1 => 'DEBIT',
             ),
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_subtype', 'enum', 7, array(
             'type' => 'enum',
             'length' => 7,
             'fixed' => false,
             'values' => 
             array(
              0 => 'VISA',
              1 => 'MAST',
              2 => 'SWITCH',
              3 => 'SOLO',
              4 => 'DELTA',
              5 => 'AMEX',
              6 => 'MAESTRO',
             ),
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_expiry_year', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_expiry_month', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_access_token', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_issue_number', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_cvc_no', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_valid_month', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('card_valid_year', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('enabled', 'enum', 8, array(
             'type' => 'enum',
             'length' => 8,
             'fixed' => false,
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             'primary' => false,
             'default' => 'ENABLED',
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}