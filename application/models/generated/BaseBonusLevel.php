<?php

/**
 * BaseBonusLevel
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $scheme_id
 * @property integer $level_id
 * @property string $level_name
 * @property float $min_points
 * @property float $max_points
 * @property float $bonus_percentage
 * @property float $fixed_bonus
 * @property float $min_deposit
 * @property float $min_total_deposit
 * @property integer $reward_times
 * @property string $description
 * @property float $fixed_real
 * @property Doctrine_Collection $audit_reports
 * @property Doctrine_Collection $loyalty_factors
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseBonusLevel extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('bonus_levels');
        $this->hasColumn('scheme_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('level_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('level_name', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('min_points', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('max_points', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('bonus_percentage', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('fixed_bonus', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('min_deposit', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('min_total_deposit', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('reward_times', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('fixed_real', 'float', null, array(
             'type' => 'float',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasMany('AuditReport as audit_reports', array(
             'local' => 'scheme_id',
             'foreign' => 'bonus_scheme_id'));

        $this->hasMany('LoyaltyFactor as loyalty_factors', array(
             'local' => 'scheme_id',
             'foreign' => 'scheme_id'));
    }
}