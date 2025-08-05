<?php
require_once(SYSTEM . 'Util/WeeklyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/WeeklyDataHandler.class.php');
class GetWeeklyDataBySymbolAndDatePage extends AbstractPage
{
    public $templateName = 'getweeklydatabysymbolanddate';

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
            $weeklyData = WeeklyDataCRUDHandler::getWeeklyDataBySymbolAndDate($symbol, $date);

            if (empty($weeklyData)) {
                $this->data['message'] = 'No data found for the given symbol and date.';
            } else {
                $this->data['weeklyData'] = $weeklyData;
                $this->data['status'] = 'success';
                $this->data['message'] = 'Data retrieved successfully';
            }
        } catch (Exception $e) {
            $this->data['message'] = 'Error: ' . $e->getMessage();
        }
    }
}