<?php

namespace app\core;

abstract class Model
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';

    public array $errors = [];
    public function loadData($data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;
    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};
            foreach ($rules as $rule){
                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                //if attr required and this attr null
                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, ['match' => $rule['match']]);
                }
                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule["class"];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $stmt = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $stmt->bindValue(":$uniqueAttr", $value);
                    $stmt->execute();
                    $existRecord = $stmt->fetchObject();
                    if($existRecord){
                        $this->addError($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }
    public function addError(string $attribute, string $rule, $params = []): void
    {
        $message = $this->errorMessage()[$rule] ?? '';
        foreach ($params as $key => $value){
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function errorMessage(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'This record with this {field} already exists',
        ];
    }
}