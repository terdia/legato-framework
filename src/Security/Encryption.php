<?php

/*
 * This file is part of the Legato package.
 *
 * (c) Osayawe Ogbemudia Terry <terry@devscreencast.com>
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace Legato\Framework\Security;

use Exception;
use RuntimeException;

class Encryption
{
    protected $key;

    protected $cipher;

    /**
     * Supported ciphers, and length.
     */
    const SUPPORTED_CIPHER_16 = 'AES-128-CBC';
    const SUPPORTED_CIPHER_32 = 'AES-256-CBC';
    const SUPPORTED_CIPHER_32_LENGTH = 32;
    const SUPPORTED_CIPHER_16_LENGTH = 16;

    /**
     * Encryption constructor.
     */
    public function __construct()
    {
        $config = getConfigPath('app', 'encryption');
        $key = $config['key'];
        $cipher = $config['cipher'];

        if (!static::valid((string) $key, $cipher)) {
            throw new RuntimeException(
                'Legato framework only support AES-256-CBC and AES-128-CBC ciphers'
            );
        }

        $this->key = $key;
        $this->cipher = $cipher;
    }

    /**
     * Check if the given key and cipher have valid length and name.
     *
     * @param $key
     * @param $cipher
     *
     * @return bool
     */
    public static function valid($key, $cipher)
    {
        $keyLength = mb_strlen($key, '8bit');

        if (static::SUPPORTED_CIPHER_32_LENGTH === $keyLength
            && $cipher === static::SUPPORTED_CIPHER_32) {
            return true;
        }

        if (static::SUPPORTED_CIPHER_16_LENGTH == $keyLength
            && $cipher === static::SUPPORTED_CIPHER_16) {
            return true;
        }
    }

    /**
     * Generate encryption key.
     *
     * @param $cipher
     *
     * @throws \Exception
     *
     * @return string
     */
    public static function generateEncryptionKey($cipher)
    {
        $key = null;
        if ($cipher === static::SUPPORTED_CIPHER_32) {
            $key = random_bytes(static::SUPPORTED_CIPHER_32_LENGTH);
        } elseif ($cipher === static::SUPPORTED_CIPHER_16) {
            $key = random_bytes(static::SUPPORTED_CIPHER_16_LENGTH);
        }

        return $key;
    }

    /**
     * Encrypt the value.
     *
     * @param $value
     *
     * @throws Exception
     *
     * @return string
     */
    public function encrypt($value)
    {
        /**
         * Gets the cipher iv length.
         */
        $iv = random_bytes(openssl_cipher_iv_length($this->cipher));

        /**
         * Encrypts the given value.
         */
        $value = \openssl_encrypt($value, $this->cipher, $this->key, 0, $iv);

        $hash_mac = $this->mac($iv = base64_encode($iv), $value);

        if (!$value) {
            throw new Exception('Unable to encrypt given value');
        }

        $encrypted = json_encode(compact('iv', 'value', 'hash_mac'));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Unable to encrypt given value.');
        }

        return base64_encode($encrypted);
    }

    /**
     * Decrypt the given data and return plain text.
     *
     * @param $data
     *
     * @throws Exception
     *
     * @return string
     */
    public function decrypt($data)
    {
        $data = json_decode(base64_decode($data), true);

        $iv = base64_decode($data['iv']);

        if (!$this->isEncryptedDataValid($data)) {
            throw new Exception('The given encrypted data is invalid.');
        }
        if (!$this->isMacValid($data, 16)) {
            throw new Exception('The hash is invalid.');
        }
        /**
         * try to decrypt.
         */
        $decrypted = \openssl_decrypt(
            $data['value'], $this->cipher, $this->key, 0, $iv
        );

        /*
         * throw exception is we cannot decrypt
         */
        if ($decrypted === false) {
            throw new Exception('Data could not be decrypted.');
        }

        return $decrypted;
    }

    /**
     * Check if the encrypted data is still valid.
     *
     * @param $data
     *
     * @return bool
     */
    protected function isEncryptedDataValid($data)
    {
        return is_array($data) && isset(
                $data['iv'], $data['value'], $data['hash_mac']
            );
    }

    /**
     * Determine if hash is valid.
     *
     * @param $data
     * @param $bytes
     *
     * @return bool
     */
    protected function isMacValid($data, $bytes)
    {
        $calculated = hash_hmac(
            'sha384', $this->mac($data['iv'], $data['value']), $bytes, true
        );

        return hash_equals(
            hash_hmac('sha384', $data['hash_mac'], $bytes, true), $calculated
        );
    }

    /**
     * hash the given value.
     *
     * @param $iv
     * @param $value
     *
     * @return string
     */
    protected function mac($iv, $value)
    {
        return hash_hmac('sha384', $iv.$value, $this->key);
    }
}
