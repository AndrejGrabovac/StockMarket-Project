<?php

class SymbolPage extends AbstractPage{

    public $templateName = 'symbol';

    public function execute(){
        $resources = [
            0 => [
                'url' => '?page=Index ',
                'method' => 'GET',
                'description' => 'Api documentation and instructions'
            ],
            1 => [
                'url' => '?page=CreateSymbol&symbol=SYMBOL_NAME',
                'method' => 'POST',
                'description' => 'Create a new symbol, supported parameters: SYMBOL_NAME'
            ],
            2 => [
                'url' => '?page=GetAllSymbols',
                'method' => 'GET',
                'description' => 'Get all symbols'
            ],
            3 => [
                'url' => '?page=GetSymbolByName&symbol=SYMBOL_NAME',
                'method' => 'GET',
                'description' => 'Get symbol by name, supported parameters: SYMBOL_NAME'
            ],
            4 => [
                'url' => '?page=GetSymbolById&symbolId=SYMBOL_ID',
                'method' => 'GET',
                'description' => 'Get symbol by ID, supported parameters: SYMBOL_ID'
            ],
            5 =>[
                'url' => '?page=UpdateSymbol&symbolId=SYMBOL_ID&newSymbolName=NEW_SYMBOL_NAME',
                'method' => 'UPDATE',
                'description' => 'Update symbol name by ID, supported parameters: SYMBOL_ID and NEW_SYMBOL_NAME',
            ],
            6 => [
                'url' => '?page=DeleteSymbolByName&symbolName=SYMBOL_NAME',
                'method' => 'DELETE',
                'description' => 'Delete a symbol by NAME, supported parameters: SYMBOL_NAME'
            ]
        ];

        $this->data = [
            'resources' => $resources
        ];

        if (isset($_GET['error'])) {
            $this->data['error'] = $_GET['error'];
        }
    }
}