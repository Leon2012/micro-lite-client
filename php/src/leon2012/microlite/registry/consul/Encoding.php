<?php
/*
 * Project: consul
 * File Created: 2019-05-17 05:34:18
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-17 05:34:26
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\registry\consul;


final class Encoding
{

    public static function encodeMetadata($metadata)
    {
        $tags = [];
        foreach ($metadata as $k => $v) {
            $b = \json_encode($v);
            $tag = "t-".self::encode($b);
            $tags[] = $tag;
        }
        return $tags;
    }

    public static function decodeMetadata($tags)
    {
        $metadata = [];
        $ver = 0;
        foreach($tags as $tag) {
            if ($tag == "" || $tag[0] != 't') {
                continue;
            }
            if ($ver > 0 && $tag[1] != $ver) {
                continue;
            }
            
            $json = '';
            if ($tag[1] == '=') {
                $json = \substr($tag, 2);
            }else if ($tag[1] == '-') {
                $str = \substr($tag, 2);
                $json = self::decode($str);
            }
            if (!empty($json)) {
                $kv = \json_decode($json, true);
                foreach($kv as $k => $v) {
                    $metadata[$k] = $v;
                }
            }
            $ver = $tag[1];
        }
        return $metadata;
    }

    public static function encodeEndpoints($en)
    {
        $tags = [];
        foreach ($en as $e) {
            $json = \json_encode($e);
            $tag = 'e-'.self::encode($json);
            $tags[] = $tag;
        }
        return $tags;
    }

    public static function decodeEndpoints($tags)
    {
        $en = [];
        $ver = 0;
        foreach ($tags as $tag) {
            if (empty($tag) || $tag[0] != 'e') {
                continue;
            }
            if ($ver > 0 && $tag[1] != $ver) {
                continue;
            }
            $json = '';
            if ($tag[1] == '=') {
                $json = \substr($tag, 2);
            }else if ($tag[1] == '-') {
                $str = \substr($tag, 2);
                $json = self::decode($str);
            }
            $e = \json_decode($json, true);
            $en[] = $e;
            $ver = $tag[1];
        }
        return $en;
    }

    public static function encodeVersion($v)
    {
        return ["v-".self::encode($v)];
    }

    public static function decodeVersion($tags)
    {
        foreach ($tags as $tag){
            if (\strlen($tag) < 2 || $tag[0] != 'v') {
                continue;
            }
            if ($tag[1] == '=') {
                return \substr($tag, 2);
            }else if ($tag[1] == '-') {
                $str = \substr($tag, 2);
                return self::decode($str);
            }
        }
    }

    public static function encode($str)
    {
        $enc = zlib_encode($str, ZLIB_ENCODING_DEFLATE, -1);
        return bin2hex($enc);
    }

    public static function decode($d)
    {
        $data = hex2bin($d);
        $dec = zlib_decode($data);
        return $dec;
    }
}