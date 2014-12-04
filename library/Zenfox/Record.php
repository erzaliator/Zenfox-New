<?php
/**
 * This file contains Zenfox_Record class which extends
 * Doctrine_Record.This is where the connection swapping
 * will happens at Record level.
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      File available since v 0.1
*/

/**
 * This class extends Doctrine_Record
 * The class gets the partitionKey (Player_id or 0, -1) depending on which
 * a partition is selected and swapped.
 *
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */

abstract class Zenfox_Record extends Doctrine_Record
{
/*    public function save($partitionKey)
    {
        if (!isset($partitionKey))
        {
            throw new Zenfox_Record_Exception ("Partition key not set for save");
        }
        else
        {
            $partition = new Zenfox_Partition();
            try
            {
                $connNames = $partition->getConnections($partitionKey);

                if (is_array($connNames))
                {
                    // Since php doesn't support late static binding in 5.2 we need to override
                    // this method to instantiate a new Zenfox_Query instead of Doctrine_Query
                    foreach ($connNames as $connName)
                    {
                        $conn = Doctrine_Manager::getInstance()->getConnection($connName);
                        parent::save($conn);
                    }
                }
                $conn = Doctrine_Manager::getInstance()->getConnection($connName);
                parent::save($conn);
            }
            catch (Zenfox_Partition_Exception $e)
            {
                throw new Zenfox_Exception("Unable to get connection to save on given partitionKey". $partitionKey . $e);
            }
        }
    }*/
}