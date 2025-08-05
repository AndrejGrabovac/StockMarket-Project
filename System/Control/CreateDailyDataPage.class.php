<?php
require_once(SYSTEM . 'Util/DailyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/DailyDataHandler.class.php');

class CreateDailyDataPage extends AbstractPage {
    public $templateName = 'createdailydata';

    public function execute()
    {
        $this->data = [
            'status' => 'No symbol provided'
        ];

        if (!empty($_GET['symbol'])) {
            $symbol = strtoupper(trim($_GET['symbol']));

            try {
                $symbolExists = SymbolCRUDHandler::symbolExistsInDatabase($symbol);

                if (!$symbolExists) {
                    $this->data['status'] = "Error: Symbol '$symbol' is not tracked. Please add it first.";
                    $this->data['error'] = true;
                    return;
                }

                $dataInserted = DailyDataHandler::insertDailyData($symbol);

                if ($dataInserted) {
                    $this->data['status'] = "Data created successfully for symbol: $symbol";
                } else {
                    $this->data['status'] = "No new data available for symbol: $symbol";
                }

                $this->data['symbol'] = $symbol;

            } catch (Exception $e) {
                $this->data['status'] = "Error: ";
                $this->data['message'] = "Error. " . $e->getMessage();
                $this->data['error'] = true;
            }
        }
    }
}