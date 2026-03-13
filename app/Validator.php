<?php

namespace MiniPHP;

class Validator
{
    private array $data;
    private array $rules;
    private array $errors = [];

    private static array $ruleMessages = [
        'required'  => ':field is required',
        'string'    => ':field must be a string',
        'integer'   => ':field must be an integer',
        'numeric'   => ':field must be numeric',
        'email'     => ':field must be a valid email',
        'boolean'   => ':field must be a boolean',
        'min'       => ':field must be at least :param characters',
        'max'       => ':field must not exceed :param characters',
        'in'        => ':field must be one of: :param',
    ];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public static function make(array $data, array $rules): self
    {
        $instance = new self($data, $rules);
        $instance->run();
        return $instance;
    }

    public function fails(): bool
    {
        return count($this->errors) > 0;
    }

    public function passes(): bool
    {
        return !$this->fails();
    }

    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @return array The validated data (only fields that had rules)
     */
    public function validated(): array
    {
        $validated = [];
        foreach (array_keys($this->rules) as $field) {
            if (array_key_exists($field, $this->data)) {
                $validated[$field] = $this->data[$field];
            }
        }
        return $validated;
    }

    private function run(): void
    {
        foreach ($this->rules as $field => $ruleString) {
            $rules = is_array($ruleString) ? $ruleString : explode('|', $ruleString);
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {
                $param = null;
                if (str_contains($rule, ':')) {
                    [$rule, $param] = explode(':', $rule, 2);
                }

                $method = 'validate' . ucfirst($rule);
                if (!method_exists($this, $method)) {
                    continue;
                }

                if (!$this->$method($value, $param)) {
                    $message = self::$ruleMessages[$rule] ?? ":field is invalid";
                    $message = str_replace(':field', $field, $message);
                    $message = str_replace(':param', $param ?? '', $message);
                    $this->errors[$field][] = $message;
                    if ($rule === 'required') {
                        break;
                    }
                }
            }
        }
    }

    private function validateRequired($value): bool
    {
        if (is_null($value)) return false;
        if (is_string($value) && trim($value) === '') return false;
        return true;
    }

    private function validateString($value): bool
    {
        return is_null($value) || is_string($value);
    }

    private function validateInteger($value): bool
    {
        return is_null($value) || filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    private function validateNumeric($value): bool
    {
        return is_null($value) || is_numeric($value);
    }

    private function validateEmail($value): bool
    {
        return is_null($value) || filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function validateBoolean($value): bool
    {
        return is_null($value) || in_array($value, [true, false, 0, 1, '0', '1'], true);
    }

    private function validateMin($value, $param): bool
    {
        if (is_null($value)) return true;
        return is_string($value) && strlen($value) >= (int) $param;
    }

    private function validateMax($value, $param): bool
    {
        if (is_null($value)) return true;
        return is_string($value) && strlen($value) <= (int) $param;
    }

    private function validateIn($value, $param): bool
    {
        if (is_null($value)) return true;
        $allowed = explode(',', $param);
        return in_array($value, $allowed, true);
    }
}
