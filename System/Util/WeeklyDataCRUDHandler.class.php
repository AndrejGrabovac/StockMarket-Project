<?php

require_once('APIHandler.php');

class WeeklyDataCRUDHandler
{
    public static function getAllWeeklyData(){
        $sql = "SELECT wsd.*, s.symbol_name as symbol 
                FROM WeeklyStockData wsd
                INNER JOIN Symbol s ON wsd.symbol_id = s.symbol_id";
        $query = AppCore::getDB()->sendQuery($sql);

        $rows = [];
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function getWeeklyDataBySymbol($symbol){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "SELECT wsd.*, s.symbol_name as symbol 
                FROM WeeklyStockData wsd
                INNER JOIN Symbol s ON wsd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol'
                ORDER BY wsd.data_date_weekly DESC";

        $query = $db->sendQuery($sql);

        $rows = [];
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function getWeeklyDataBySymbolAndDate($symbol, $date){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);
        $date = $db->escapeString($date);

        $sql = "SELECT wsd.*, s.symbol_name as symbol 
                FROM WeeklyStockData wsd
                INNER JOIN Symbol s ON wsd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol' AND wsd.data_date_weekly = '$date'";

        $query = $db->sendQuery($sql);

        $rows = [];
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function deleteWeeklyDataBySymbol($symbol){
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "DELETE wsd FROM WeeklyStockData wsd
                INNER JOIN Symbol s ON wsd.symbol_id = s.symbol_id
                WHERE s.symbol_name = '$symbol'";

        $db->sendQuery($sql);
    }
}
