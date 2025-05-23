<?php

class IndexPage extends AbstractPage{

    public $templateName = 'index';

    public function execute(){
        $resources = [
            1 => [
                'url' => 'Index',
                'method' => 'GET',
                'description' => 'Api documentation and instructions'
            ]
        ];

        $this->data = [
            'resources' => $resources
        ];
    }
}