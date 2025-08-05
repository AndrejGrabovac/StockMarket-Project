<?php

require_once(SYSTEM . 'Util/WeeklyDataHandler.class.php');
require_once(SYSTEM . 'Util/WeeklyDataCRUDHandler.class.php');

class UpdateWeeklyDataPage extends AbstractPage
{
    protected $templateName = 'updateweeklydata';
    protected function execute()
    {
        $symbol = isset($_GET['symbol']) ? trim($_GET['symbol']) : '';

        if (empty($symbol)) {
            $this->data['error'] = true;
            $this->data['status'] = 'Error';
            $this->data['message'] = 'Missing or invalid symbol parameter.';
            return;
        }

        try {
            $result = WeeklyDataHandler::updateWeeklyData($symbol);

            if ($result['noExistingData']) {
                $this->data['error'] = true;
                $this->data['status'] = 'Error';
                $this->data['message'] = 'No existing data found for symbol. Please insert data first.';
                return;
            }

            $this->data['message'] = $result['count'] === 0
                ? 'No new weekly data to update for this symbol.'
                : 'Weekly data updated successfully.';
            $this->data['data'] = [
                'updatedCount' => $result['count'],
                'updatedDates' => $result['dates'],
                'mostRecentDate' => $result['mostRecentDate']
            ];
        } catch (\Exception $e) {
            $this->data['error'] = true;
            $this->data['status'] = 'Error';
            $this->data['message'] = 'Failed to update weekly data: ' . $e->getMessage();
        }
    }
}