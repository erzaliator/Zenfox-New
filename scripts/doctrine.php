<?php
require_once('config/database.php');

// Configure Doctrine Cli
// Normally these are arguments to the cli tasks but if they are set here the arguments will be auto-filled
$config = array('data_fixtures_path'  =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '../application/doctrine/data/fixtures',
                'models_path'         =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '../application/doctrine/models',
                'migrations_path'     =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '../application/doctrine/migrations',
                'sql_path'            =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '../application/doctrine/data/sql',
                'yaml_schema_path'    =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '../application/doctrine/schema');

$cli = new Doctrine_Cli($config);
$cli->run($_SERVER['argv']);
