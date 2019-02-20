<?php

/**
 * Des 加密
 * 
 * @package     crypt-tools-example
 * @subpackage  example
 * @version     0.1
 * 
 */

class Des implements CryptInterface {

	public static function encrypt ($data, $key) : string {
		$key = self::getKey($key);
		return openssl_encrypt ($data, 'des-ecb', $key);
	}


	public static function decrypt ($data, $key) {
		$key = self::getKey($key);
		return openssl_decrypt ($data, 'des-ecb', $key); 
	}

	static function getKey(string $key) : string  {
		return md5($key);
	}
}