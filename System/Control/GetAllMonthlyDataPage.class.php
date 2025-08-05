<?php
require_once(SYSTEM . 'Util/MonthlyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/MonthlyDataHandler.class.php');
class GetAllMonthlyDataPage extends AbstractPage{

    public $templateName = 'getallmonthlydata';

    public function execute(){
        try {
            $monthlyData = MonthlyDataCRUDHandler::getAllMonthlyData();
            $this->data = [
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'monthlyData' => $monthlyData
            ];
        } catch (Exception $e) {
            $this->data = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

    }
}