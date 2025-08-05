<?php


class SymbolCRUDHandler
{
    public static function createSymbol($symbol)
    {
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "SELECT symbol_id FROM Symbol WHERE symbol_name = '$symbol'";
        $query = $db->sendQuery($sql);

        if ($query && $query->num_rows > 0) {
            $row = $query->fetch_assoc();
            return $row['symbol_id'];
        }

        $sql = "INSERT INTO Symbol (symbol_name) VALUES ('$symbol')";
        $result = $db->sendQuery($sql);

        if (!$result) {
            throw new DatabaseException("Failed to create symbol: " . $db->getError());
        }

        $sql = "SELECT symbol_id FROM Symbol WHERE symbol_name = '$symbol'";
        $query = $db->sendQuery($sql);

        if (!$query || $query->num_rows === 0) {
            throw new DatabaseException("Failed to retrieve newly created symbol ID");
        }

        $row = $query->fetch_assoc();
        return $row['symbol_id'];
    }

    public static function getAllSymbols(){
        $db = AppCore::getDB();
        $sql = "SELECT * FROM Symbol";
        $query = $db->sendQuery($sql);

        if (!$query) {
            throw new DatabaseException("Failed retrieving symbols");
        }

        $symbols = [];
        while ($row = $query->fetch_assoc()) {
            $symbols[] = $row;
        }
        return $symbols;
    }

    public static function getSymbolByName($symbolName)
    {
        $db = AppCore::getDB();
        $symbolName = $db->escapeString($symbolName);

        $sql = "SELECT * FROM Symbol WHERE symbol_name = '$symbolName'";
        $query = $db->sendQuery($sql);

        if ($query && $query->num_rows > 0) {
            return $query->fetch_assoc();
        }

        return null;
    }

    public static function getSymbolById($symbolId)
    {
        $db = AppCore::getDB();
        $symbolId = (int)$symbolId;

        $sql = "SELECT * FROM Symbol WHERE symbol_id = $symbolId";
        $query = $db->sendQuery($sql);

        if ($query && $query->num_rows > 0) {
            return $query->fetch_assoc();
        }

        return null;
    }

    public static function updateSymbol($symbolId, $newName)
    {
        $db = AppCore::getDB();
        $symbolId = (int)$symbolId;
        $newName = $db->escapeString($newName);

        $sql = "SELECT symbol_id FROM Symbol WHERE symbol_name = '$newName' AND symbol_id != $symbolId";
        $query = $db->sendQuery($sql);

        if (self::symbolExistsInDatabase($newName)) {
            throw new DatabaseException("Symbol name '$newName' already exists");
        }

        $sql = "UPDATE Symbol SET symbol_name = '$newName' WHERE symbol_id = $symbolId";
        $result = $db->sendQuery($sql);

        if (!$result) {
            throw new DatabaseException("Failed to update symbol: " . $db->getError());
        }

        return true;
    }

    public static function deleteSymbolByName($symbolName)
    {
        $db = AppCore::getDB();
        $symbolName = $db->escapeString($symbolName);

        $sql = "DELETE FROM Symbol WHERE symbol_name = '$symbolName'";
        $result = $db->sendQuery($sql);

        if (!$result) {
            throw new DatabaseException("Failed to delete symbol: " . $db->getError());
        }

        return true;
    }

    public static function symbolExistsInDatabase($symbol)
    {
        $db = AppCore::getDB();
        $symbol = $db->escapeString($symbol);

        $sql = "SELECT symbol_id FROM Symbol WHERE symbol_name = '$symbol'";
        $query = $db->sendQuery($sql);

        return ($query && $query->num_rows > 0);
    }
}