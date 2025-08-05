<?php

require_once(SYSTEM . 'Util/WeeklyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/WeeklyDataHandler.class.php');
require_once(SYSTEM . 'Util/SymbolCRUDHandler.class.php');

/**
 * CreateWeeklyDataPage
 *
 * Controller for creating initial weekly data for a symbol
 */
class CreateWeeklyDataPage extends AbstractPage
{
    public $templateName = 'createweeklydata';

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

                if (WeeklyDataHandler::hasWeeklyDataForSymbol($symbol)) {
                    $this->data['status'] = "Error: Weekly data for symbol '$symbol' already exists. Use UpdateWeeklyData endpoint to update.";
                    $this->data['error'] = true;
                    return;
                }

                $dataInserted = WeeklyDataHandler::insertWeeklyData($symbol);

                if ($dataInserted) {
                    $this->data['status'] = "Success";
                    $this->data['message'] = "Successfully inserted weekly data for symbol '$symbol'.";
                    $this->data['data'] =
                    $this->data['error'] = false;
                }else{
                    $this->data['status'] = "No new data available for symbol: $symbol";
                }

            } catch (Exception $e) {
                $this->data['status'] = "Error";
                $this->data['message'] = $e->getMessage();
                $this->data['error'] = true;
            }
        }
    }
}