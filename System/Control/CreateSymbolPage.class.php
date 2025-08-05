<?php

require_once(SYSTEM . 'Util/SymbolCRUDHandler.class.php');

class CreateSymbolPage extends AbstractPage{

    public $templateName = 'createsymbol';

    public function execute(){

        $this->data = [
            'status' => 'No symbol provided'
        ];

        if (isset($_GET['error'])) {
            $this->data['error'] = $_GET['error'];
        }
        if (!empty($_GET['symbol'])) {
            $symbol = strtoupper(trim($_GET['symbol']));

            try {
                if (!preg_match('/^[A-Z0-9.]{1,10}$/', $symbol)) {
                    $this->data['status'] = "Error: Invalid symbol format. Use 1-10 uppercase letters, numbers or dots.";
                    $this->data['error'] = true;
                    return;
                }

                if (SymbolCRUDHandler::symbolExistsInDatabase($symbol)) {
                    $symbolData = SymbolCRUDHandler::getSymbolByName($symbol);
                    $this->data['status'] = "Symbol '$symbol' already exists in database with ID: {$symbolData['symbol_id']}";
                    $this->data['symbol'] = $symbol;
                    $this->data['symbol_id'] = $symbolData['symbol_id'];
                } else {
                    $symbolId = SymbolCRUDHandler::createSymbol($symbol);

                    if ($symbolId) {
                        $this->data['status'] = "Symbol '$symbol' created successfully with ID: $symbolId";
                        $this->data['symbol'] = $symbol;
                        $this->data['symbol_id'] = $symbolId;
                    } else {
                        $this->data['status'] = "Error: Failed to create symbol '$symbol'";
                        $this->data['error'] = true;
                    }
                }
            } catch (DatabaseException $e) {
                $this->data['status'] = "Error: " . $e->getMessage();
                $this->data['error'] = true;
            } catch (Exception $e) {
                $this->data['status'] = "Unexpected error: " . $e->getMessage();
                $this->data['error'] = true;
            }
        }

        if (isset($_GET['error'])) {
            $this->data['error'] = $_GET['error'];
        }
    }
}