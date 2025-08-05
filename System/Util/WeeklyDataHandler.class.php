<?php

require_once(SYSTEM . 'Util/WeeklyDataCRUDHandler.class.php');
require_once(SYSTEM . 'Util/SymbolCRUDHandler.class.php');

/**
 * WeeklyDataHandler
 *
 * Handles operations related to weekly stock data
 */
class WeeklyDataHandler
{
    public static function hasWeeklyDataForSymbol($symbol)
    {
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "SELECT 1 FROM WeeklyStockData wsd
            INNER JOIN Symbol s ON wsd.symbol_id = s.symbol_id
            WHERE s.symbol_name = '$symbol'
            LIMIT 1";

        $query = $db->sendQuery($sql);

        return $query->num_rows > 0;
    }
    public static function getMostRecentDateForSymbol($symbol)
    {
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "SELECT MAX(wsd.data_date_weekly) as latest_date
                FROM WeeklyStockData wsd
                INNER JOIN Symbol s ON wsd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol'";

        $query = $db->sendQuery($sql);
        $result = $query->fetch_assoc();

        return isset($result['latest_date']) ? $result['latest_date'] : null;
    }

    public static function insertWeeklyData($symbol)
    {
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);
        $insertedCount = 0;

        try {
            // Get data from API
            $weeklyData = APIHandler::getWeeklyData($symbol);

            if (!isset($weeklyData['Weekly Time Series']) || !is_array($weeklyData['Weekly Time Series'])) {
                throw new Exception("Invalid API response structure: Weekly Time Series data not found");
            }

            // Get symbol ID
            $symbolData = SymbolCRUDHandler::getSymbolByName($symbol);
            if (!$symbolData) {
                throw new Exception("Symbol '$symbol' not found in database");
            }
            $symbolId = $symbolData['symbol_id'];

            // Check if we already have data for this symbol
            $hasExistingData = self::hasWeeklyDataForSymbol($symbol);

            // Sort dates in descending order
            $dates = array_keys($weeklyData['Weekly Time Series']);
            usort($dates, function($a, $b) {
                return strtotime($b) - strtotime($a);
            });

            // Insert data for each date
            foreach ($dates as $date) {
                // Check if this specific record already exists
                if ($hasExistingData) {
                    $checkSql = "SELECT 1 FROM WeeklyStockData wsd 
                           WHERE wsd.symbol_id = $symbolId 
                           AND wsd.data_date_weekly = '" . $db->escapeString($date) . "'
                           LIMIT 1";

                    $checkResult = $db->sendQuery($checkSql);

                    if ($checkResult && $checkResult->num_rows > 0) {
                        continue; // Skip this record as it already exists
                    }
                }

                $weekData = $weeklyData['Weekly Time Series'][$date];

                $sql = "INSERT INTO WeeklyStockData
                   (symbol_id, data_date_weekly, open_price_weekly, high_price_weekly,
                    low_price_weekly, close_price_weekly, volume)
                   VALUES (
                       $symbolId,
                       '" . $db->escapeString($date) . "',
                       '" . $db->escapeString($weekData['1. open']) . "',
                       '" . $db->escapeString($weekData['2. high']) . "',
                       '" . $db->escapeString($weekData['3. low']) . "',
                       '" . $db->escapeString($weekData['4. close']) . "',
                       '" . $db->escapeString($weekData['5. volume']) . "'
                   )";

                $result = $db->sendQuery($sql);

                if (!$result) {
                    throw new Exception("Failed to insert data for date $date: " . $db->error);
                }

                $insertedCount++;
            }

            return $insertedCount > 0;

        } catch (Exception $e) {
            error_log("Error inserting weekly data for $symbol: " . $e->getMessage());
            throw new Exception("Failed to insert weekly data: " . $e->getMessage());
        }
    }

    public static function updateWeeklyData($symbol)
    {
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        try {
            $mostRecentDate = self::getMostRecentDateForSymbol($symbol);
            if ($mostRecentDate === null) {
                return [
                    'count' => 0,
                    'noExistingData' => true
                ];
            }

            $weeklyData = APIHandler::getWeeklyData($symbol);

            if (!isset($weeklyData['Weekly Time Series']) || !is_array($weeklyData['Weekly Time Series'])) {
                throw new Exception("Invalid API response structure: Weekly Time Series data not found");
            }

            $symbolData = SymbolCRUDHandler::getSymbolByName($symbol);
            $symbolId = $symbolData['symbol_id'];

            $dates = array_keys($weeklyData['Weekly Time Series']);
            usort($dates, function($a, $b) {
                return strtotime($b) - strtotime($a);
            });

            $updateCount = 0;
            $updatedDates = [];

            foreach ($dates as $date) {
                if ($date <= $mostRecentDate) {
                    continue;
                }

                $weekData = $weeklyData['Weekly Time Series'][$date];

                $sql = "INSERT INTO WeeklyStockData
                (symbol_id, data_date_weekly, open_price_weekly, high_price_weekly,
                low_price_weekly, close_price_weekly, volume)
                VALUES (
                    $symbolId,
                    '" . $db->escapeString($date) . "',
                    '" . $db->escapeString($weekData['1. open']) . "',
                    '" . $db->escapeString($weekData['2. high']) . "',
                    '" . $db->escapeString($weekData['3. low']) . "',
                    '" . $db->escapeString($weekData['4. close']) . "',
                    '" . $db->escapeString($weekData['5. volume']) . "'
                )";
                $db->sendQuery($sql);
                $updateCount++;
                $updatedDates[] = $date;
            }

            return [
                'count' => $updateCount,
                'dates' => $updatedDates,
                'mostRecentDate' => $mostRecentDate,
                'noExistingData' => false
            ];
        } catch (Exception $e) {
            error_log("Error updating weekly data $symbol: " . $e->getMessage());
            throw $e;
        }
    }
}