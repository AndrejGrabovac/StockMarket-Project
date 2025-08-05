<?php
require_once(SYSTEM . 'Util/DailyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/DailyDataHandler.class.php');
class GetAllDailyDataBySymbolPage extends AbstractPage
{
    public $templateName = 'getalldailydatabysymbol';

    public function execute()
    {
        $this->data = [
            'status' => 'error',
            'message' => 'No symbol provided'
        ];

        if (!empty($_GET['symbol'])) {
            $symbol = strtoupper(trim($_GET['symbol']));

            try {
                $stockData = DailyDataCRUDHandler::getDailyDataBySymbol($symbol);

                if (empty($stockData)) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = "No data found for symbol: $symbol";
                } else {
                    $this->data['status'] = 'success';
                    $this->data['message'] = "Data retrieved successfully for symbol: $symbol";
                    $this->data['stockData'] = $stockData;
                }
            } catch (Exception $e) {
                $this->data['status'] = 'error';
                $this->data['message'] = $e->getMessage();
            }
        }
    }
}