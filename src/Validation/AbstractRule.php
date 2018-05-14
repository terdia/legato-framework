<?php


namespace Legato\Framework\Validator;


class AbstractRule
{
    protected function removeSpaces($value)
    {
        return trim($value);
    }

    public function shouldNotBeEmpty($value)
    {
        return $value != null && !empty($this->removeSpaces($value));
    }

}