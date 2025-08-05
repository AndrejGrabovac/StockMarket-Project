<?php

class MonthlyDataPage extends AbstractPage{

    public $templateName = 'monthlydata';

    public function execute(){
        $resources = [
            1 => [
                'url' => '?page=MonthlyData',
                'method' => 'GET',
                'description' => 'Api documentation for MonthlyData and instructions'
            ],
            2 => [
                'url' => '?page=CreateMonthlyData&symbol=SYMBOL',
                'method' => 'POST',
                'description' => 'Create a new monthly data entry, supported parameters: SYMBOL'
            ],
            3 => [
                'url' => '?page=GetAllMonthlyData',
                'method' => 'GET',
                'description' => 'Get all monthly data entries'
            ],
            4 => [
                'url' => '?page=GetAllMonthlyDataBySymbol&symbol=SYMBOL',
                'method' => 'GET',
                'description' => 'Get all Monthly data entries for a specific symbol, supported parameters: SYMBOL'
            ],
            5 => [
                'url' => '?page=GetMonthlyDataBySymbolAndDate&symbol=SYMBOL&date=YYYY-MM-DD',
                'method' => 'GET',
                'description' => 'Get Monthly data for a specific symbol and date, supported parameters: SYMBOL and DATE (YYYY-MM-DD)'
            ],
            6 => [
                'url' => '?page=DeleteMonthlyDataBySymbol&symbol=SYMBOL',
                'method' => 'DELETE',
                'description' => 'Delete all Monthly data entries for a specific symbol, supported parameters: SYMBOL'
            ],
            7 => [
                'url' => '?page=UpdateMonthlyData&symbol=SYMBOL',
                'method' => 'POST',
                'description' => 'Update Monthly data for a specific symbol, supported parameters: SYMBOL'
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