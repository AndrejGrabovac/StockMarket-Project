<?php

class IndexPage extends AbstractPage{

    public $templateName = 'index';

    public function execute(){
        $resources = [
            1 => [
                'url' => '?page=Index ',
                'method' => 'GET',
                'description' => 'Api documentation and instructions'
            ],
            2 => [
                'url' => '?page=DailyData',
                'method' => 'GET',
                'description' => 'Api documentation for DailyData and instructions'
            ],
            3 => [
                'url' => '?page=WeeklyData',
                'method' => 'GET',
                'description' => 'Api documentation for WeeklyData and instructions'
            ],
            4 => [
                'url' => '?page=MonthlyData',
                'method' => 'GET',
                'description' => 'Api documentation for MonthlyData and instructions'
            ],
            5 => [
                'url' => '?page=YearlyData',
                'method' => 'GET',
                'description' => 'Api documentation for YearlyData and instructions'
            ],
            6 => [
                'url' => '?page=Symbol',
                'method' => 'GET',
                'description' => 'Api documentation for Symbol and instructions'
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