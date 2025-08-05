<?php
require_once(SYSTEM . 'Util/DailyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/DailyDataHandler.class.php');
class GetDailyDataBySymbolAndDatePage extends AbstractPage
{
    public $templateName = 'getdailydatabysymbolanddate';

    public function execute()
    {
        $this->data = [
            'status' => 'error',
            'message' => 'Missing parameters'
        ];

        $symbol = isset($_GET['symbol']) ? strtoupper($_GET['symbol']) : null;
        $date = isset($_GET['date']) ? $_GET['date'] : null;

        if (!$symbol || !$date) {
            $this->data['message'] = 'Symbol and date parameters are required.';
            return;
        }

        try {
            $dailyData = DailyDataCRUDHandler::getDailyDataBySymbolAndDate($symbol, $date);

            if (empty($dailyData)) {
                $this->data['message'] = 'No data found for the given symbol and date.';
            } else {
                $this->data['dailyData'] = $dailyData;
                $this->data['status'] = 'success';
                $this->data['message'] = 'Data retrieved successfully';
            }
        } catch (Exception $e) {
            $this->data['message'] = 'Error: ' . $e->getMessage();
        }
    }
}