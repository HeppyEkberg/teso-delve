<?php namespace HeppyKarlsson\LuaJson;

class LuaJson
{

    static public function toJson($string) {
        $string = str_replace('["', '"', $string);
        $string = str_replace('"]', '"', $string);
        $string = str_replace('[', '"', $string);
        $string = str_replace(']', '"', $string);
        $string = str_replace(' =', ': ', $string);
        $string = trim(preg_replace('/\s\s+/', ' ', $string));
        $string = str_ireplace(', }', ' }', $string);
        $first_match = stripos($string, '{');
        $string = substr($string, $first_match);
        $json = json_decode($string, true);

        return $json;
    }

}