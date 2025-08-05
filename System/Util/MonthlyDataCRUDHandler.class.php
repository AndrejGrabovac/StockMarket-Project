<?php
require_once('APIHandler.php');
class MonthlyDataCRUDHandler
{
    public static function getAllMonthlyData(){
        $sql = "SELECT msd.*, s.symbol_name as symbol
                FROM MonthlyStockData msd
                INNER JOIN Symbol s ON msd.symbol_id = s.symbol_id";
        $query = AppCore::getDB()->sendQuery($sql);

        $rows = [];
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function getMothlyDataBySymbol($symbol){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "SELECT msd.*, s.symbol_name as symbol 
                FROM MonthlyStockData msd
                INNER JOIN Symbol s ON msd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol'
                ORDER BY msd.data_date_monthly DESC";

        $query = $db->sendQuery($sql);
        $rows = [];
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function getMonthlyDataBySymbolAndDate($symbol, $date){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);
        $date = $db->escapeString($date);
        $sql = "SELECT msd.*, s.symbol_name as symbol 
                FROM MonthlyStockData msd
                INNER JOIN Symbol s ON msd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol' AND msd.data_date_monthly = '$date'";

        $query = $db->sendQuery($sql);

        $rows = [];
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function deleteMonthlyDataBySymbol($symbol){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "DELETE FROM MonthlyStockData 
                WHERE symbol_id = (SELECT symbol_id FROM Symbol WHERE symbol_name = '$symbol')";

        $db->sendQuery($sql);
    }
}