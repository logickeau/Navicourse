<?php
/**
 * @package     Navicourse
 * @name NV_Mgrs
 * @description Geographical grid converter.
 * @author      Jean N. Pijeau <nick.pijeau@gmail.com>
 */
class NV_Mgrs
{
    var $northingIDs = array(
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'J',
        'K',
        'L',
        'M',
        'N',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V');
    function UTMtoLatLon($f, $f1, $j)
    {
        $d = 0.99960000000000004; // scale along long0
        $d1 = 6378137; // Polar Radius
        $d2 = 0.0066943799999999998;
        $d4 = (1 - sqrt(1 - $d2)) / (1 + sqrt(1 - $d2));
        $d15 = $f1 - 500000;
        $d16 = $f;
        $d11 = (($j - 1) * 6 - 180) + 3;
        $d3 = $d2 / (1 - $d2);
        $d10 = $d16 / $d;
        $d12 = $d10 / ($d1 * (1 - $d2 / 4 - (3 * $d2 * $d2) / 64 - (5 * pow($d2, 3)) /
            256));
        $d14 = $d12 + ((3 * $d4) / 2 - (27 * pow($d4, 3)) / 32) * sin(2 * $d12) + ((21 *
            $d4 * $d4) / 16 - (55 * pow($d4, 4)) / 32) * sin(4 * $d12) + ((151 * pow($d4, 3)) /
            96) * sin(6 * $d12);
        $d13 = rad2deg($d14);
        $d5 = $d1 / sqrt(1 - $d2 * sin($d14) * sin($d14));
        $d6 = tan($d14) * tan($d14);
        $d7 = $d3 * cos($d14) * cos($d14);
        $d8 = ($d1 * (1 - $d2)) / pow(1 - $d2 * sin($d14) * sin($d14), 1.5);
        $d9 = $d15 / ($d5 * $d);
        $d17 = $d14 - (($d5 * tan($d14)) / $d8) * ((($d9 * $d9) / 2 - (((5 + 3 * $d6 +
            10 * $d7) - 4 * $d7 * $d7 - 9 * $d3) * pow($d9, 4)) / 24) + (((61 + 90 * $d6 +
            298 * $d7 + 45 * $d6 * $d6) - 252 * $d3 - 3 * $d7 * $d7) * pow($d9, 6)) / 720);
        $d17 = rad2deg($d17); // Breddegrad (N)
        $d18 = (($d9 - ((1 + 2 * $d6 + $d7) * pow($d9, 3)) / 6) + (((((5 - 2 * $d7) + 28 *
            $d6) - 3 * $d7 * $d7) + 8 * $d3 + 24 * $d6 * $d6) * pow($d9, 5)) / 120) / cos($d14);
        $d18 = $d11 + rad2deg($d18); // LÃ¦ngdegrad (Ã˜)
        return new NV_Lat_Lng($d17, $d18);
    }
    function fromUTM($utm)
    {
        $lngZone = $utm->lngZone;
        $set = (($lngZone - 1) % 6) + 1;
        $eID = floor($utm->easting / 100000.0) + (8 * (($set - 1) % 3));
        $nID = floor(($utm->northing % 2000000.0) / 100000.0);
        if ($eID > 8)
            $eID++; // Offset for no I character
        if ($eID > 14)
            $eID++; // Offset for no O character
        $eIDc = chr($eID + 64);
        // Northing ID offset for sets 2, 4 and 6
        if ($set % 2 == 0) {
            $nID += 5;
        }
        if ($nID > 19) {
            $nID -= 20;
        }
        $nIDc = $this->northingIDs[$nID];
        $this->utmZoneNumber = $lngZone;
        $this->utmZoneChar = $utm->latZone;
        $this->eastingID = $eIDc;
        $this->northingID = $nIDc;
        $this->easting = round($utm->easting) % 100000;
        $this->northing = round($utm->northing) % 100000;
        $this->precision = 1;
    }
    function toUTMRef()
    {
        $lngZone = $this->utmZoneNumber;
        $set = (($lngZone - 1) % 6) + 1;
        $eIDc = $this->eastingID;
        $eID = ord($eIDc) - 64;
        if ($eID > 8)
            $eID--; // Offset for no I character
        if ($eID > 14)
            $eID--; // Offset for no O character
        $e = ($eID - (8 * (($set - 1) % 3))) * 100000.0;
        $nIDc = $this->northingID;
        $nID = array_search($nIDc, $this->northingIDs);
        // Northing ID offset for sets 2, 4 and 6
        if ($set % 2 == 0) {
            $nID -= 5;
        }
        if ($nID < 0) {
            $nID += 20;
        }
        $n = $nID * 100000.0;
        $n = ($n % 1000000) * 1.0;
        $arr = array(
            'C' => 1100000.0,
            'D' => 2000000.0,
            'E' => 2800000.0,
            'F' => 3700000.0,
            'G' => 4600000.0,
            'H' => 5500000.0,
            'J' => 6400000.0,
            'K' => 7300000.0,
            'L' => 8200000.0,
            'M' => 9100000.0,
            'N' => 0.0,
            'P' => 800000.0,
            'Q' => 1700000.0,
            'R' => 2600000.0,
            'S' => 3500000.0,
            'T' => 4400000.0,
            'U' => 5300000.0,
            'V' => 6200000.0,
            'W' => 7000000.0,
            'X' => 7900000.0);
        $min = $arr[$this->utmZoneChar];
        while ($n < $min) {
            $n += 1000000;
        }
        return new NV_Utmref($e + $this->easting, $n + $this->northing, $this->
            utmZoneChar, $this->utmZoneNumber);
    }
    function parseString($str)
    {
        #30V WH 62367 06531
        preg_match('/(\d+)([A-Z])\s*([A-Z])([A-Z])\s*(\d{1,5})\s*(\d{1,5})/', strtoupper
            ($str), $m);
        $s2 = $m[5] . $m[6];
        $len2 = strlen($s2) / 2;
        $m[5] = substr($s2, 0, $len2);
        $m[6] = substr($s2, $len2, $len2);
        if (strlen($s2) < 10) {
            $m[5] = $m[5] * pow(10, 5 - $len2);
            $m[6] = $m[6] * pow(10, 5 - $len2);
        }
        $this->utmZoneNumber = $m[1] + 0;
        $this->utmZoneChar = $m[2];
        $this->eastingID = $m[3];
        $this->northingID = $m[4];
        $this->easting = $m[5] + 0;
        $this->northing = $m[6] + 0;
        $this->precision = pow(10, 5 - strlen($s2) / 2);
    }
    function toString($precision)
    {
        if ($precision != 1 && precision != 10 && precision != 100 && precision != 1000 &&
            precision != 10000) {
            die("Precision (" + precision + ") must be 1m, 10m, 100m, 1000m or 10000m");
        }
        $eastingR = floor($this->easting / $precision);
        $northingR = floor($this->northing / $precision);
        $padding = 5;
        switch ($precision) {
            case 10:
                $padding = 4;
                break;
            case 100:
                $padding = 3;
                break;
            case 1000:
                $padding = 2;
                break;
            case 10000:
                $padding = 1;
                break;
        }
        $ez = $padding - strlen($eastingR);
        while ($ez > 0) {
            $eastingR = '0' . $eastingR;
            $ez--;
        }
        $nz = $padding - strlen($northingR);
        while ($nz > 0) {
            $northingR = '0' . $northingR;
            $nz--;
        }
        $utmZonePadding = '';
        if ($this->utmZoneNumber < 10) {
            $utmZonePadding = '0';
        }
        return $utmZonePadding . $this->utmZoneNumber . $this->utmZoneChar . ' ' . $this->
            eastingID . $this->northingID . ' ' . $eastingR . ' ' . $northingR;
    }
    function convert($grid, $point)
    {
        $this->parseString($grid . '' . $point);
        $utm3 = $this->toUTMRef();
        $lonLat = $this->UTMtoLatLon($utm3->northing, $utm3->easting, $utm3->lngZone);
        return $lonLat;
    }
}