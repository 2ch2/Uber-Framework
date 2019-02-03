<?php

namespace uber\Utils;

/**
 * Class, which contains utilities for
 * strings.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class StringUtils
{
    /**
     * Required to correct route working, matches
     * variables in url.
     *
     * @param string $str1
     * @param string $str2
     * @return array|string
     */
    public static function strlcs(string $str1, string $str2)
    {
        $str1Len = strlen($str1);
        $str2Len = strlen($str2);
        $ret = [];

        if ($str1Len == 0 || $str2Len == 0) {
            return $ret;
        }

        $CSL = [];
        $intLargestSize = 0;

        for ($i = 0; $i < $str1Len; $i++) {
            $CSL[$i] = [];
            for ($j = 0; $j < $str2Len; $j++) {
                $CSL[$i][$j] = 0;
            }
        }

        for ($i = 0; $i < $str1Len; $i++) {
            for ($j = 0; $j < $str2Len; $j++) {
                if ($str1[$i] == $str2[$j]) {
                    if ($i == 0 || $j == 0) {
                        $CSL[$i][$j] = 1;
                    } else {
                        $CSL[$i][$j] = ($CSL[($i - 1)][($j - 1)] + 1);
                    }

                    if ($CSL[$i][$j] > $intLargestSize) {
                        $intLargestSize = $CSL[$i][$j];
                        $ret = [];
                    }

                    if ($CSL[$i][$j] == $intLargestSize) {
                        $ret[] = substr($str1, ($i - $intLargestSize + 1), $intLargestSize);
                    }
                }
            }
        }

        if (isset($ret[0])) {
            return $ret[0];
        } else {
            return '';
        }
    }
}