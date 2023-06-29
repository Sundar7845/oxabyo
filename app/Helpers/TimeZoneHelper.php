<?php

if (!function_exists('getCountryByIpAddress')) {
    function getCountryByIpAddress()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['REMOTE_HOST'])) {
            $ipaddress = $_SERVER['REMOTE_HOST'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
        // $ipaddress = '14.102.2.85';
        $result = \DB::select('SELECT c.code,c.country FROM ip2nationCountries c,ip2nation i WHERE i.ip < INET_ATON(?)
                AND c.code = i.country ORDER BY i.ip DESC LIMIT 0,1', [$ipaddress]);
        $countryCode = '';
        $ipcountry = '';
        if ($row = array_pop($result)) {
            $countryCode = $row->code;
            $ipcountry = $row->country;
        }
        $countryCode = !$countryCode ? 'Not Define' : $countryCode;
        $ipcountry = !$ipcountry ? 'Not Define' : $ipcountry;
        $countryName = $ipcountry;
        $data = array();
        $data['countryCode'] = $countryCode;
        $data['countryName'] = $countryName;
        return $data;
    }
}

if (!function_exists('getTimeZoneByIpAddress')) {
    function getTimeZoneByIpAddress()
    {
        $country = getCountryByIpAddress();
        $gettimezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, strtoupper($country['countryCode']));
        if ($gettimezone) {
            $timezone = $gettimezone[0];
            return $timezone;
        }
        return null;
    }
}

if (!function_exists('getUTCDate')) {
    function getUTCDate($date, $hour, $timezone) {
        date_default_timezone_set($timezone);
        $newDate = new DateTime($date. " ". $hour);
        $newDate->setTimezone(new DateTimeZone('UTC'));
        return $newDate->format('Y-m-d');
    }
}

if (!function_exists('getUTCTime')) {
    function getUTCTime($date, $hour, $timezone) {
        date_default_timezone_set($timezone);
        $newDate = new DateTime($date. " ". $hour);
        $newDate->setTimezone(new DateTimeZone('UTC'));
        return $newDate->format('H:i');
    }
}

if (!function_exists('getDateByTimZone')) {
    function getDateByTimZone($date, $hour, $timezone) {
        date_default_timezone_set('UTC');
        $newDate = new DateTime($date. " ". $hour);
        if ($timezone) {
            $newDate->setTimezone(new DateTimeZone($timezone ?? 'UTC'));
        } else {
            $newDate->setTimezone(new DateTimeZone('UTC'));
        }
        
        return $newDate->format('Y-m-d');
    }
}

if (!function_exists('getTimeByTimeZone')) {
    function getTimeByTimeZone($date, $hour, $timezone) {
        date_default_timezone_set('UTC');
        $newDate = new DateTime($date. " ". $hour);
        if ($timezone) {
            $newDate->setTimezone(new DateTimeZone($timezone ?? 'UTC'));
        } else {
            $newDate->setTimezone(new DateTimeZone('UTC'));
        }
        return $newDate->format('H:i');
    }
}
