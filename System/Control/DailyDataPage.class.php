<?php
class DailyDataPage extends AbstractPage{

    public $templateName = 'dailydata';

    public function execute(){

        $resources = [
            0 => [
                'url' => '?page=Index',
                'method' => 'GET',
                'description' => 'Api documentation and instructions'
            ],
            1 => [
                'url' => '?page=DailyData',
                'method' => 'GET',
                'description' => 'Api documentation for DailyData and instructions'
            ],
            2 => [
                'url' => '?page=CreateDailyData&symbol=SYMBOL',
                'method' => 'POST',
                'description' => 'Post daily data to the database, supported parameters: SYMBOL'
            ],
            3 => [
                'url' => '?page=GetAllDailyData',
                'method' => 'GET',
                'description' => 'Get all daily data'
            ],
            4 => [
                'url' => '?page=GetAllDailyDataBySymbol&symbol=SYMBOL',
                'method' => 'GET',
                'description' => 'Get all daily data by symbol, supported parameters: SYMBOL'
            ],
            5 => [
                'url' => '?page=GetDailyDataBySymbolAndDate&symbol=SYMBOL&date=YYYY-MM-DD',
                'method' => 'GET',
                'description' => 'Get daily data by symbol and date, supported parameters: SYMBOL and date in format YYYY-MM-DD'
            ],
            6 => [
                'url' => '?page=DeleteDailyDataBySymbol&symbol=SYMBOL',
                'method' => 'DELETE',
                'description' => 'Delete daily data by symbol, supported parameters: SYMBOL'
            ],
        ];

        $this->data = [
            'resources' => $resources
        ];
    }
}