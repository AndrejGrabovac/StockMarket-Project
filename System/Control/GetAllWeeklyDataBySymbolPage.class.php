<?php
require_once(SYSTEM . 'Util/WeeklyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/WeeklyDataHandler.class.php');
class GetAllWeeklyDataBySymbolPage extends AbstractPage
{
    public $templateName = 'getallweeklydatabysymbol';

    public function execute()
    {
        $this->data = [
            'status' => 'error',
            'message' => 'No symbol provided'
        ];

        if (!empty($_GET['symbol'])) {
            $symbol = strtoupper(trim($_GET['symbol']));

            try {
                $weeklyData = WeeklyDataCRUDHandler::getWeeklyDataBySymbol($symbol);

                if (empty($weeklyData)) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = "No data found for symbol: $symbol";
                } else {
                    $this->data['status'] = 'success';
                    $this->data['message'] = "Data retrieved successfully for symbol: $symbol";
                    $this->data['weeklyData'] = $weeklyData;
                }
            } catch (Exception $e) {
                $this->data['status'] = 'error';
                $this->data['message'] = $e->getMessage();
            }
        }
    }
}