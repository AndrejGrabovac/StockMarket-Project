<?php

require_once('APIHandler.php');

class DailyDataCRUDHandler
{
    public static function getAllDailyData(){
        $sql = "SELECT dsd.*, s.symbol_name as symbol 
                FROM DailyStockData dsd
                INNER JOIN Symbol s ON dsd.symbol_id = s.symbol_id";;
        $query = AppCore::getDB()->sendQuery($sql);

        $rows = [];
        while ($row = $query -> fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function getDailyDataBySymbol($symbol){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "SELECT dsd.*, s.symbol_name as symbol 
                FROM DailyStockData dsd
                INNER JOIN Symbol s ON dsd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol'
                ORDER BY dsd.data_date_daily DESC";

        $query = $db->sendQuery($sql);

        $rows = [];
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function getDailyDataBySymbolAndDate($symbol, $date){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);
        $date = $db->escapeString($date);

        $sql = "SELECT dsd.*, s.symbol_name as symbol 
                FROM DailyStockData dsd
                INNER JOIN Symbol s ON dsd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol' AND dsd.data_date_daily = '$date'";

        $query = $db->sendQuery($sql);

        $rows = [];
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;

    }

    public static function deleteDailyDataBySymbol($symbol){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "DELETE dsd FROM DailyStockData dsd
                INNER JOIN Symbol s ON dsd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol'";

        $db->sendQuery($sql);
    }


}