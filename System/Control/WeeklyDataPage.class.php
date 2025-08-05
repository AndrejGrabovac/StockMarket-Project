<?php

class WeeklyDataPage extends AbstractPage{

    public $templateName = 'weeklydata';

    public function execute(){
        $resources = [
            1 => [
                'url' => '?page=WeeklyData',
                'method' => 'GET',
                'description' => 'Api documentation for WeeklyData and instructions'
            ],
            2 => [
                'url' => '?page=CreateWeeklyData&symbol=SYMBOL',
                'method' => 'POST',
                'description' => 'Create a new weekly data entry, supported parameters: SYMBOL'
            ],
            3 => [
                'url' => '?page=GetAllWeeklyData',
                'method' => 'GET',
                'description' => 'Get all weekly data entries'
            ],
            4 => [
                'url' => '?page=GetAllWeeklyDataBySymbol&symbol=SYMBOL',
                'method' => 'GET',
                'description' => 'Get all weekly data entries for a specific symbol, supported parameters: SYMBOL'
            ],
            5 => [
                'url' => '?page=GetWeeklyDataBySymbolAndDate&symbol=SYMBOL&date=YYYY-MM-DD',
                'method' => 'GET',
                'description' => 'Get weekly data for a specific symbol and date, supported parameters: SYMBOL and DATE (YYYY-MM-DD)'
            ],
            6 => [
                'url' => '?page=DeleteWeeklyDataBySymbol&symbol=SYMBOL',
                'method' => 'DELETE',
                'description' => 'Delete all weekly data entries for a specific symbol, supported parameters: SYMBOL'
            ],
            7 => [
                'url' => '?page=UpdateWeeklyData&symbol=SYMBOL',
                'method' => 'POST',
                'description' => 'Update weekly data for a specific symbol, supported parameters: SYMBOL'
            ],
        ];

        $this->data = [
            'resources' => $resources
        ];

        if (isset($_GET['error'])) {
            $this->data['error'] = $_GET['error'];
        }
    }
}