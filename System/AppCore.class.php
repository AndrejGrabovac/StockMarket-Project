<?php

define('SYSTEM' , dirname(__FILE__) . '/');

require(SYSTEM . 'core.functions.php');
require(SYSTEM . 'Util/RequestHandler.class.php');
require(SYSTEM . 'Model/AbstractPage.class.php');

class AppCore{

    protected static $dbObj;

    function __construct(){
        $this->initOptions();
        $this->initDB();
        RequestHandler::handle();
    }

    private function initDB()
    {
        require_once('config.inc.php');
        require_once('Model/MySQLiDatabase.class.php');

        self::$dbObj = new MySQLiDatabase(
            DB_HOST,
            DB_USER,
            DB_PASSWORD,
            DB_NAME
        );
    }

    public static final function getDB(){
        return self::$dbObj;
    }

    private function initOptions()
    {
        require(SYSTEM . 'options.inc.php');
    }
}




































































