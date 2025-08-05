<?php

class RequestHandler
{
    private static $validPages = [
        'index' => 'Index',
        'dailydata' => 'DailyData',
        'weeklydata' => 'WeeklyData',
        'monthlydata' => 'MonthlyData',
        'yearlydata' => 'YearlyData',

        'createdailydata' => 'CreateDailyData',
        'getalldailydata' => 'GetAllDailyData',
        'getalldailydatabysymbol' => 'GetAllDailyDataBySymbol',
        'getdailydatabysymbolanddate' => 'GetDailyDataBySymbolAndDate',
        'deletedailydatabysymbol' => 'DeleteDailyDataBySymbol',
        'updatedailydata' => 'UpdateDailyData',

        'pagenotfound' => 'PageNotFound',

        'symbol' => 'Symbol',
        'createsymbol' => 'CreateSymbol',
        'getallsymbols' => 'GetAllSymbols',
        'getsymbolbyname' => 'GetSymbolByName',
        'getsymbolbyid' => 'GetSymbolById',
        'updatesymbol' => 'UpdateSymbol',
        'deletesymbolbyname' => 'DeleteSymbolByName',

        'createweeklydata' => 'CreateWeeklyData',
        'getallweeklydata' => 'GetAllWeeklyData',
        'getallweeklydatabysymbol' => 'GetAllWeeklyDataBySymbol',
        'getweeklydatabysymbolanddate' => 'GetWeeklyDataBySymbolAndDate',
        'deleteweeklydatabysymbol' => 'DeleteWeeklyDataBySymbol',
        'updateweeklydata' => 'UpdateWeeklyData',

        'createmonthlydata' => 'CreateMonthlyData',
        'getallmonthlydata' => 'GetAllMonthlyData',
        'getallmonthlydatabysymbol' => 'GetAllMonthlyDataBySymbol',
        'getmonthlydatabysymbolanddate' => 'GetMonthlyDataBySymbolAndDate',
        'deletemonthlydatabysymbol' => 'DeleteMonthlyDataBySymbol',
        'updatemonthlydata' => 'UpdateMonthlyData',

        'createyearlydata' => 'CreateYearlyData',
        'getallyearlydata' => 'GetAllYearlyData',
        'getallyearlydatabysymbol' => 'GetAllYearlyDataBySymbol',
        'getyearlydatabysymbolanddate' => 'GetYearlyDataBySymbolAndDate',
        'deleteyearlydatabysymbol' => 'DeleteYearlyDataBySymbol',
        'updateyearlydata' => 'UpdateYearlyData',
    ];

    public function __construct($className)
    {
        require_once(SYSTEM . 'Model/AbstractPage.class.php');

        $lowerClassName = strtolower($className);
        if (array_key_exists($lowerClassName, self::$validPages)) {
            $pageClassName = self::$validPages[$lowerClassName] . 'Page';
            require_once(SYSTEM . '/Control/' . $pageClassName . '.class.php');
            new $pageClassName();
        } else {
            require_once(SYSTEM . '/Control/PageNotFoundPage.class.php');
            $pageNotFound = new PageNotFoundPage();
            $pageNotFound->execute();
            exit;
        }
    }

    public static function handle()
    {
        $request = isset($_GET['page']) ? $_GET['page'] : 'Index';
        new RequestHandler($request);
    }
}































