<?php
/**
 * Rsa 文件加密
 *
 * @package     crypt-tools-example
 * @subpackage  example
 * @version     0.1
 *
 * 密钥采用openssl工具生成，命令：
 *
 * 教程：http://www.hanzikang.cn/article/17
 * 1. 生成 rsa 私钥
 * openssl genrsa -out rsaprivatekey.pem 1024
 * 2. 生成对应的公钥
 * openssl rsa -in rsaprivatekey.pem -pubout -out rsapublickey.pem
 * 3. 将 RSA 私钥转换成 PKCS8 格式,
 * openssl pkcs8 -topk8 -inform PEM -in rsaprivatekey.pem -outform PEM -nocrypt -out
 * rsaprivatepkcs8.pem
 */

class Rsa implements CryptInterface {

	private static $_pi_key = null;
	private static $_pu_key = null;

	static function setPrivateFile($file) {
        return self::$_pi_key =  openssl_pkey_get_private($file);
	}

	static function setPublicFile($file) {
        return self::$_pu_key = openssl_pkey_get_public($file);
	}

    public static function encrypt($data, $key):string {
        $key = self::getKey($key);
        \openssl_public_encrypt($data,$encrypted, self::$_pu_key);
        return $encrypted;
    }

    public static function decrypt($data, $key) {
        openssl_private_decrypt($data,$decrypted,self::$_pi_key);
        return $decrypted;
    }

    static function sign($data) {
        openssl_sign($data, $sign, self::$_pi_key, OPENSSL_ALGO_SHA1);
        $sign = base64_encode($sign);
        return $sign;
    }

    static function checkSign($data, $sign) {
        $sign = base64_decode($sign);
        $result = openssl_verify($data, $sign, self::$_pu_key, OPENSSL_ALGO_SHA1) === 1;
        return $result;
    }

    static function getKey(string $key):string {
        return md5($key);
    }
}
    