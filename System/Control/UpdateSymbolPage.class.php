<?php
require_once(SYSTEM . 'Util/SymbolCRUDHandler.class.php');

/**
 * UpdateSymbolPage
 *
 * Handles API requests to update a symbol's name
 */
class UpdateSymbolPage extends AbstractPage
{
    public $templateName = 'updatesymbol';

    /**
     * Execute the API request to update a symbol
     *
     * @return void
     */
    public function execute()
    {
        try {
            $missingParams = [];

            if (empty($_GET['symbolId'])) {
                $missingParams[] = 'symbolId';
            }

            if (empty($_GET['newSymbolName'])) {
                $missingParams[] = 'newSymbolName';
            }

            if (!empty($missingParams)) {
                $this->data = [
                    'status' => 'error',
                    'message' => 'Missing required parameters: ' . implode(', ', $missingParams),
                    'data' => $_POST
                ];
                return;
            }

            $symbolId = (int)$_GET['symbolId'];
            $newSymbolName = trim($_GET['newSymbolName']);

            if ($symbolId <= 0) {
                $this->data = [
                    'status' => 'error',
                    'message' => 'Invalid symbol ID',
                    'data' => ['receivedId' => $symbolId]
                ];
                return;
            }

            if (empty($newSymbolName)) {
                $this->data = [
                    'status' => 'error',
                    'message' => 'Symbol name cannot be empty',
                    'data' => []
                ];
                return;
            }

            SymbolCRUDHandler::updateSymbol($symbolId, $newSymbolName);

            $updatedSymbol = SymbolCRUDHandler::getSymbolById($symbolId);

            $this->data = [
                'status' => 'success',
                'message' => 'Symbol updated successfully',
                'data' => $updatedSymbol
            ];
        } catch (Exception $e) {
            $this->data = [
                'status' => 'error',
                'message' => 'Failed to update symbol: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }
}