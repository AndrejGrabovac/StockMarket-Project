<?php

require_once(SYSTEM . 'Util/WeeklyDataCRUDHandler.class.php');

class GetAllWeeklyDataPage extends AbstractPage
{

    public $templateName = 'getallweeklydata';

    public function execute()
    {
        try {
            $weeklyData = WeeklyDataCRUDHandler::getAllWeeklyData();
            $this->data = [
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'weeklyData' => $weeklyData
            ];
        } catch (Exception $e) {
            $this->data = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

    }
}