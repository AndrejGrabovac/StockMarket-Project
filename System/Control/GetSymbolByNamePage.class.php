<?php
require_once(SYSTEM . 'Util/SymbolCRUDHandler.class.php');

class GetSymbolByNamePage extends AbstractPage
{
    public $templateName = 'getsymbolbyname';

    public function execute()
    {
        try {
            if (empty($_GET['symbol'])) {
                $this->data = [
                    'status' => 'error',
                    'message' => 'Symbol name is required'
                ];
                return;
            }

            $symbolName = $_GET['symbol'];
            $symbol = SymbolCRUDHandler::getSymbolByName($symbolName);

            if ($symbol) {
                $this->data = [
                    'status' => 'success',
                    'message' => 'Symbol retrieved successfully',
                    'data' => $symbol
                ];
            } else {
                $this->data = [
                    'status' => 'error',
                    'message' => "Symbol '$symbolName' not found"
                ];
            }
        } catch (Exception $e) {
            $this->data = [
                'status' => 'error',
                'message' => 'Failed to retrieve symbol: ' . $e->getMessage()
            ];
        }
    }
}