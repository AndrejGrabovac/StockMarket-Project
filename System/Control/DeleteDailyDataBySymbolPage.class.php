<?php
require_once(SYSTEM . 'Util/DailyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/DailyDataHandler.class.php');

class DeleteDailyDataBySymbolPage extends AbstractPage
{
    public $templateName = 'deletedailydatabysymbol';

    public function execute()
    {
        $this->data = [
            'status' => 'error',
            'message' => 'No symbol provided'
        ];

        if (!empty($_GET['symbol'])) {
            $symbol = strtoupper(trim($_GET['symbol']));

            try {

                $existingData = DailyDataCRUDHandler::getDailyDataBySymbol($symbol);

                if (empty($existingData)) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = "No data found for symbol: $symbol";
                } else {
                    DailyDataCRUDHandler::deleteDailyDataBySymbol($symbol);
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