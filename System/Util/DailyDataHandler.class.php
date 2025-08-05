<?php

require_once(SYSTEM . 'Util/SymbolCRUDHandler.class.php');

class DailyDataHandler
{
    public static function getMostRecentDateForSymbol($symbol)
    {
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "SELECT MAX(dsd.data_date_daily) as latest_date 
                FROM DailyStockData dsd
                INNER JOIN Symbol s ON dsd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol'";

        $query = $db->sendQuery($sql);
        $result = $query->fetch_assoc();

        return isset($result['latest_date']) ? $result['latest_date'] : null;
    }

    public static function insertDailyData($symbol)
    {
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        try {
            $dailyData = APIHandler::getDailyData($symbol);

            if (!isset($dailyData['Time Series (Daily)']) || !is_array($dailyData['Time Series (Daily)'])) {
                throw new Exception("Invalid API response structure: Time Series (Daily) data not found");
            }
            $symbolData = SymbolCRUDHandler::getSymbolByName($symbol);
            $symbolId = $symbolData['symbol_id'];

            $mostRecentDate = self::getMostRecentDateForSymbol($symbol);
            $isExistingSymbol = ($mostRecentDate !== null);

            $dates = array_keys($dailyData['Time Series (Daily)']);
            usort($dates, function($a, $b) {
                return strtotime($b) - strtotime($a);
            });

            $insertCount = 0;
            foreach ($dates as $date) {
                if ($isExistingSymbol && $date <= $mostRecentDate) {
                    continue;
                }

                $dayData = $dailyData['Time Series (Daily)'][$date];

                $sql = "INSERT INTO DailyStockData
                (symbol_id, data_date_daily, open_price_daily, high_price_daily,
                low_price_daily, close_price_daily, volume)
                VALUES (
                    $symbolId,
                    '" . $db->escapeString($date) . "',
                    '" . $db->escapeString($dayData['1. open']) . "',
                    '" . $db->escapeString($dayData['2. high']) . "',
                    '" . $db->escapeString($dayData['3. low']) . "',
                    '" . $db->escapeString($dayData['4. close']) . "',
                    '" . $db->escapeString($dayData['5. volume']) . "'
                )";

                $db->sendQuery($sql);
                $insertCount++;
            }

            return $insertCount > 0;
        } catch (Exception $e) {
            throw new DatabaseException("Error inserting daily data: " . $e->getMessage());
        }

    }

    public static function checkIfSymbolExist($symbol){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "SELECT dsd.* FROM DailyStockData dsd
                INNER JOIN Symbol s ON dsd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol' LIMIT 1";

        $query = $db->sendQuery($sql);

        return mysqli_num_rows($query) > 0;
    }

    public static function checkIfTableIsEmpty()
    {
        $sql = "SELECT * FROM DailyStockData LIMIT 1";
        $query = AppCore::getDB()->sendQuery($sql);

        return mysqli_num_rows($query) > 0;
    }
}