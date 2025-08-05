<?php
require_once(SYSTEM . 'Util/SymbolCRUDHandler.class.php');

class DeleteSymbolByNamePage extends AbstractPage
{
    public $templateName = 'deletesymbolbyname';

    public function execute()
    {
        try {
            if (empty($_GET['symbolName'])) {
                http_response_code(400);
                $this->data = [
                    'status' => 'error',
                    'message' => 'Symbol name is required',
                    'data' => []
                ];
                return;
            }

            $symbolName = $_GET['symbolName'];

            $existingSymbol = SymbolCRUDHandler::getSymbolByName($symbolName);
            if (!$existingSymbol) {
                $this->data = [
                    'status' => 'error',
                    'message' => "Symbol '$symbolName' not found",
                    'data' => []
                ];
                return;
            }

            SymbolCRUDHandler::deleteSymbolByName($symbolName);

            $this->data = [
                'status' => 'success',
                'message' => "Symbol '$symbolName' deleted successfully",
                'data' => $existingSymbol
            ];
        } catch (Exception $e) {
            $this->data = [
                'status' => 'error',
                'message' => 'Failed to delete symbol: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }
}