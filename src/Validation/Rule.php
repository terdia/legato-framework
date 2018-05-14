<?php


namespace Legato\Framework\Validator;

use Legato\Framework\Connection as DB;

class Rule extends AbstractRule
{
    /**
     * @param $column, field name
     * @param $value, value passed into the form
     * @param $policy, the rule that e set e.g min = 5
     * @return bool, true | false
     */
    public function unique($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            return !DB::table($policy)->where($column, '=', $value)->exists();
        }
        return true;
    }

    public function required($column, $value, $policy)
    {
        return $this->shouldNotBeEmpty($value);
    }

    public function min($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            return strlen($value) >= $policy;
        }
        return true;
    }

    public function max($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            return strlen($value) <= $policy;
        }
        return true;
    }

    public function email($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            return filter_var(filter_var($value, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        }

        return true;
    }

    public function mixed($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            if(!preg_match('/^[A-Za-z0-9 .,_~\-!@#\&%\^\'\*\(\)]+$/', $value)){
                return false;
            }
        }
        return true;
    }

    public function alphaNum($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            return ctype_alnum($value);
        }
        return true;
    }

    public function alpha($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            return ctype_alpha($value);
        }
        return true;
    }

    public function string($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            if(!preg_match('/^[A-Za-z ]+$/', $value)){
                return false;
            }
        }
        return true;
    }

    public function numeric($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            return ctype_digit($value);
        }
        return true;
    }

    public function float($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            if(!filter_var($value, FILTER_VALIDATE_FLOAT)){
                return false;
            }
        }
        return true;
    }

    public function url($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
            if(!filter_var(filter_var($value, FILTER_SANITIZE_URL), FILTER_VALIDATE_URL)){
                return false;
            }
        }
        return true;
    }

    public function ip($column, $value, $policy)
    {
        if($this->shouldNotBeEmpty($value)){
           return filter_var($value, FILTER_VALIDATE_IP);
        }
        return true;
    }

}