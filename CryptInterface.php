<?php

/**
* Crypt 加密interface
*/
interface CryptInterface
{
	/**
	 * 加密
	 * @author Yk 2019-02-20
	 * @param  string $data 数据源
	 * @param  string $key  key
	 * @return string
	 */
	public static function encrypt(string $data, string $key='') : string;
	/**
	 * 解密
	 * @param  string $data 数据源
	 * @param  string $key  key
	 * @return string
	 */
	public static function decrypt(string $data, string $key);
}