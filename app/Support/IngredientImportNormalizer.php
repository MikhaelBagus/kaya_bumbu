<?php

namespace App\Support;

class IngredientImportNormalizer
{
    public static function text($value): string
    {
        $value = preg_replace('/\s+/u', ' ', trim((string) $value)) ?? '';

        return mb_strtoupper($value, 'UTF-8');
    }

    public static function group($value): string
    {
        $value = self::text($value);

        if (self::key($value) === 'LAINLAIN') {
            return 'LAIN-LAIN';
        }

        return $value;
    }

    public static function category($value): string
    {
        $value = self::text($value);
        $key = self::key($value);

        if ($key === 'MINYAKLEMAKSANTAN') {
            return 'MINYAK, LEMAK & SANTAN';
        }

        if (in_array($key, ['PRODUKOLAHANSIAPSAJI', 'PRODAKOLAHANSIAPSAJI'], true)) {
            return 'PRODAK OLAHAN & SIAP SAJI';
        }

        return $value;
    }

    public static function item($value): string
    {
        $value = self::text($value);
        $key = self::key($value);

        if ($key === 'THINWALLBULAT200ML') {
            return 'THINWALL BULAT 200ML';
        }

        if ($key === 'THINWALLCUP100ML') {
            return 'THINWALL CUP - 100ML';
        }

        if ($key === 'THINWALLCUP150ML') {
            return 'THINWALL CUP - 150ML';
        }

        if ($key === 'THINWALLKOTAK1000ML') {
            return 'THINWALL KOTAK 1000ML';
        }

        return $value;
    }

    public static function unit($value): string
    {
        $unit = self::text($value);

        if (in_array($unit, ['LTR', 'LITER'], true)) {
            return 'LITER';
        }

        if (in_array($unit, ['LMBR', 'LEMBAR'], true)) {
            return 'LEMBAR';
        }

        return $unit;
    }

    private static function key(string $value): string
    {
        return preg_replace('/[^\pL\pN]+/u', '', $value) ?? '';
    }
}
