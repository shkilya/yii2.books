<?php

namespace common\helpers;

/**
 * Class Hash
 *
 * @package cms\helpers
 */
class Hash
{
    /**
     * @param array $data
     * @return string
     */
    public static function makeHash(array $data): string
    {
        $flat = [];

        static::walk($data, function($value, $key) use (&$flat) {
            $flat[] = $key . ':' . $value;
        });

        sort($flat, SORT_STRING);

        $str = implode('-', $flat);

        return md5($str);
    }

    /**
     * @param array $data
     * @param callable $callback
     * @param string $parentKey
     */
    protected static function walk(array $data, callable $callback, string $parentKey = '')
    {
        foreach ($data as $key => $value) {
            if (!empty($parentKey)) {
                $key = $parentKey . '.' . $key;
            }

            if (is_array($value)) {
                static::walk($value, $callback, $key);
            } else {
                $callback($value, $key);
            }
        }
    }
}