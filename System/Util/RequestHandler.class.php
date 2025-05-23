<?php

class RequestHandler
{

    public function __construct($className)
    {
        require_once(SYSTEM . 'Model/AbstractPage.class.php');
        $className = $className . 'Page';
        require_once('System/Control/' . $className . '.class.php');
        new $className();
    }

    public static function handle()
    {
        $request = isset($_GET['page']) ? $_GET['page'] : 'Index';
        new RequestHandler($request);
    }
}































