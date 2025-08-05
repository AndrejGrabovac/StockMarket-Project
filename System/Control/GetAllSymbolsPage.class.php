<?php
require_once(SYSTEM . 'Util/SymbolCRUDHandler.class.php');
class GetAllSymbolsPage extends AbstractPage{

    public $templateName = 'getallsymbols';

    public function execute(){
        try {
            $symbols = SymbolCRUDHandler::getAllSymbols();
            $this->data = [
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'symbols' => $symbols
            ];
        } catch (Exception $e) {
            $this->data = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

    }
}