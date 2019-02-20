<?php

/**
 * Base64 文件加密
 * 
 * @package     crypt-tools-example
 * @subpackage  example
 * @version     0.1
 * 
 */

class Base64 implements CryptInterface {


	public static function encrypt ($data, $key) : string {
		$key = self::getKey($key);
        $data   =   base64_encode($data);
        // 使用key 进行数据串联
        $x=0;
		$len = strlen($data);
		$l = strlen($key);
		$str = $char = '';
        for ($i=0;$i< $len;$i++) {
            if ($x== $l) $x=0;
            $char   .=substr($key,$x,1);
            $x++;
        }

        for ($i=0;$i< $len;$i++) {
            $str    .=chr(ord(substr($data,$i,1))+(ord(substr($char,$i,1)))%256);
        }
        return $str;

	}

	public static function decrypt ($data, $key) {
		$key = self::getKey($key);
        $x=0;
        $len = strlen($data);
        $l = strlen($key);
        $str = $char = '';
        for ($i=0;$i< $len;$i++) {
            if ($x== $l) $x=0;
            $char   .=substr($key,$x,1);
            $x++;
        }
        for ($i=0;$i< $len;$i++) {
            if (ord(substr($data,$i,1))<ord(substr($char,$i,1))) {
                $str    .=chr((ord(substr($data,$i,1))+256)-ord(substr($char,$i,1)));
            }else{
                $str    .=chr(ord(substr($data,$i,1))-ord(substr($char,$i,1)));
            }
        }
        $data = base64_decode($str);
        return $data;
	}

	static function getKey(string $key) : string  {
		return md5($key);
	}

}