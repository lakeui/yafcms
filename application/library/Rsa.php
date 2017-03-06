
<?php

/**
 * Rsa 加密
 */
class Rsa {
    /*
     * #openssl req -x509 -out public_key.der -outform der -new -newkey rsa:1024 -keyout private_key.pem -days 36500
     * 设置秘密
     * #openssl rsa -in private_key.pem -pubout -out public_key.pem
     * 参考：http://blog.yorkgu.me/2011/10/27/rsa-in-ios-using-publick-key-generated-by-openssl/
     */

    const RSA_PASSWORD = 'bb#$34^&';
   
        /**
     * 返回对应的私钥
     */
    private static function getPrivateKey() {
        $privKey = file_get_contents(APP_PATH . '/cert/private_key.pem');
        return openssl_pkey_get_private($privKey, self::RSA_PASSWORD);
    }

    /**
     * 私钥加密
     */
    public static function privEncrypt($data) {
        if (!is_string($data)) {
            return null;
        }
        return openssl_private_encrypt($data, $encrypted, self::getPrivateKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 私钥解密
     */
    public static function privDecrypt($encrypted) {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;
    }

    /**
     * 公钥加密,使用私钥解密
     */
    public static function pubEncrypt($str) {
        $public_key = self::publicKey();
        if (openssl_public_encrypt($str, $encrypted, $public_key)) {
            return base64_encode($encrypted);
        }
        //安全网络传输
    }

    /**
     * 公钥解密
     */
    public static function pubDecrypt($str) {
        $public_key = self::publicKey();
        if (openssl_public_decrypt($str, $decrypted, $public_key)) {
            return $decrypted;
        }
    }

    private static function publicKey() {
        $public_key = file_get_contents(APP_PATH . '/cert/public_key.pem');
        return openssl_pkey_get_public($public_key);
    }

}
