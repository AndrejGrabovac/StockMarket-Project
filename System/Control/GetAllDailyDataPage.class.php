<?php
require_once(SYSTEM . 'Util/DailyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/DailyDataHandler.class.php');
class GetAllDailyDataPage extends AbstractPage{

    public $templateName = 'getalldailydata';

    public function execute(){
        try {
            $stockData = DailyDataCRUDHandler::getAllDailyData();
            $this->data = [
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'stockData' => $stockData
            ];
        } catch (Exception $e) {
            $this->data = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

    }
}