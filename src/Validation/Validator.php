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

namespace Legato\Framework\Validator;

class Validator
{
    protected $messages;

    protected $errorHandler;

    protected $customMessages;

    protected $errors;

    public function __construct(array $data, array $rules, $customValidationErrorMessages = [])
    {
        $this->create($data, $rules, $customValidationErrorMessages);
    }

    /**
     * Perform validation for the data provider and set error messages.
     *
     * @param array $data
     */
    private function parseData(array $data)
    {
        $field = $data['field'];

        foreach ($data['policies'] as $rule => $policy) {
            $passes = call_user_func_array([new Rule(), $rule], [$field, $data['value'], $policy]);

            if (!$passes) {
                ErrorHandler::set(
                    str_replace(
                        [':attribute', ':policy', '_'],
                        [$field, $policy, ' '], $this->messages[$rule]), $field
                );
            }
        }
    }

    /**
     * @param array $data,     fields and values pair under validation
     * @param array $policies, the rules that validation must satisfy
     * @param array $messages, custom validation messages
     */
    public function create(array $data, array $policies, array $messages = [])
    {
        $this->customMessages = $messages;
        $this->messages = ErrorHandler::getValidationMessages($this->customMessages);
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($policies))) {
                $this->parseData(
                    ['field' => $field, 'value' => $value, 'policies' => $policies[$field]]
                );
            }
        }
    }

    /**
     * Check if validation failed.
     *
     * @return bool
     */
    public function fail()
    {
        return ErrorHandler::has();
    }

    /**
     * Set the error messages.
     *
     * @return $this
     */
    public function error()
    {
        $this->errors = ErrorHandler::all();

        return $this;
    }

    /**
     * Check if a given key exists in error message.
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->errors[$key] ? true : false;
    }

    /**
     * Get the first element in the validation error array for given key.
     *
     * @param null $key
     *
     * @return mixed
     */
    public function first($key = null)
    {
        return $this->errors[$key][0];
    }

    /**
     * Get all error messages or all errors under a specified key.
     *
     * @param null $key
     *
     * @return mixed
     */
    public function get($key = null)
    {
        return $key ? $this->errors[$key] : $this->errors;
    }
}
