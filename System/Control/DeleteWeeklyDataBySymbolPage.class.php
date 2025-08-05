<?php
require_once(SYSTEM . 'Util/WeeklyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/WeeklyDataHandler.class.php');

class DeleteWeeklyDataBySymbolPage extends AbstractPage
{
    public $templateName = 'deleteweeklydatabysymbol';

    public function execute()
    {
        $this->data = [
            'status' => 'error',
            'message' => 'No symbol provided'
        ];

        if (!empty($_GET['symbol'])) {
            $symbol = strtoupper(trim($_GET['symbol']));

            try {

                $existingData = WeeklyDataCRUDHandler::getWeeklyDataBySymbol($symbol);

                if (empty($existingData)) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = "No data found for symbol: $symbol";
                } else {
                    WeeklyDataCRUDHandler::deleteWeeklyDataBySymbol($symbol);;
                    $this->data['status'] = 'success';
                    $this->data['message'] = "Data deleted successfully for symbol: $symbol";
                }
            } catch (Exception $e) {
                $this->data['status'] = 'error';
                $this->data['message'] = $e->getMessage();
            }
        }
    }
}