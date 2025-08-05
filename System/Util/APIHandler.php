<?php

class APIHandler
{
    private static function makeRequest($url)
    {
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (isset($data['Information']) && strpos($data['Information'], 'API rate limit') !== false) {
            throw new Exception("API rate limit exceeded: " . $data['Information']);
        }

        // Check for other API errors
        if (isset($data['Error Message'])) {
            throw new Exception("API Error: " . $data['Error Message']);
        }

        return $data;
    }

    public static function getDailyData($symbol)
    {
        $url = 'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=' . urlencode($symbol) . '&apikey=' . API_KEY;
        return self::makeRequest($url);
    }

    public static function getWeeklyData($symbol)
    {
        $url = 'https://www.alphavantage.co/query?function=TIME_SERIES_WEEKLY&symbol=' . urlencode($symbol) . '&apikey=' . API_KEY;
        return self::makeRequest($url);
    }

    public static function getMonthlyData($symbol)
    {
        $url = 'https://www.alphavantage.co/query?function=TIME_SERIES_MONTHLY&symbol=' . urlencode($symbol) . '&apikey=' . API_KEY;
        return self::makeRequest($url);
    }
}