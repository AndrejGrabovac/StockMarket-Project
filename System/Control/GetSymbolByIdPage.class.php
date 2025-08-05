<?php
require_once(SYSTEM . 'Util/SymbolCRUDHandler.class.php');

class GetSymbolByIdPage extends AbstractPage
{
    public $templateName = 'getsymbolbyid';

    public function execute()
    {
        try {
            if (empty($_GET['symbolId'])) {
                $this->data = [
                    'status' => 'error',
                    'message' => 'Symbol ID is required'
                ];
                return;
            }

            $symbolId = $_GET['symbolId'];
            $symbol = SymbolCRUDHandler::getSymbolById($symbolId);

            if ($symbol) {
                $this->data = [
                    'status' => 'success',
                    'message' => 'Symbol retrieved successfully',
                    'data' => $symbol
                ];
            } else {
                $this->data = [
                    'status' => 'error',
                    'message' => "Symbol '$symbolId' not found"
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