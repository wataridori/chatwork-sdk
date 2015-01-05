<?php

namespace wataridori\ChatworkSDK\Helper;

class Text
{
    /**
     * Convert from snake_case to camelCase
     * For example it_is_an_example => itIsAnExample
     * @param $string string the inputted word
     * @return string the Words
     */
    public static function snakeToCamel($string)
    {
        $words = explode('_', $string);
        $text = '';
        foreach ($words as $index => $word) {
            if ($index) {
                $text .= ucfirst($word);
            } else {
                $text .= $word;
            }
        }

        return $text;
    }

    /**
     * Convert a camelCase string to snake_case
     * @param $string string
     * @return string
     */
    public static function camelToSnake($string)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}