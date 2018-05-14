<?php


namespace Legato\Framework\Validator;


class ErrorHandler
{
    private static $error = [];

    /**
     * Set specific error
     *
     * @param $error
     * @param null $key
     */
    public static function set($error, $key = null)
    {
        if($key){
            static::$error[$key][] = $error;
        }else{
            static::$error[] = $error;
        }
    }

    /**
     * Return true if there is validation error
     *
     * @return bool
     */
    public static function has()
    {
        return count(static::$error) > 0 ? true : false;
    }

    /**
     * Return all validation errors
     *
     * @return array
     */
    public static function all()
    {
        return static::$error;
    }

    /**
     * Set and returns default custom validation messages
     *
     * @param array $custom
     * @return array
     */
    public static function getValidationMessages($custom = [])
    {
        $default = (array) require_once __DIR__ .'/messages.php';

        foreach ($custom as $key => $value){
            if(array_key_exists($key, $default))
            {
                $default[$key] = $value;
            }
        }
        return $default;
    }
}