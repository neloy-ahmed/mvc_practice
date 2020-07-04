<?php
class Validator{

    private $is_valid = true;

    public $errors = [];


    public function isValid(): bool
    {
        return $this->is_valid;
    }


    public function getError($fieldName)
    {
        return isset($this->errors[$fieldName]) ? $this->errors['fieldName'] : '';
    }


    public function validate(array $rules, array $payload)
    {
        foreach ($rules as $rule) {

            if (!$this->validateRequired($rule, $payload)) {
                continue;
            }
            switch ($rule['type']) {

                case 'email':
                    $this->validateEmail($rule, $payload);
                    break;
                case 'numeric':
                    $this->validateNumeric($rule, $payload);
                    break;
                case 'alpha_neumeric_space':
                    $this->validateAlphaNeumericSpace($rule, $payload);
                    break;
                case 'alpha':
                    $this->validateAlpha($rule, $payload);
                    break;
                case 'alpha_comma_space':
                    $this->validateAlphaCommaSpace($rule, $payload);
                    break;
                case 'alpha_space':
                    $this->validateAlphaSpace($rule, $payload);
                    break;
                case 'max_character':
                    $this->validateMaxCharacterLength($rule, $payload);
                    break;
                case 'max_word':
                    $this->validateMaxWordLength($rule, $payload);
                    break;
                case 'valid_date':
                    $this->validateDate($rule);
                    break;

            }
        }

        return $this->isValid();
    }

    public function validateRequired(array $rule, array $payload)
    {
        if (true === $rule['required'] && empty($payload[$rule['fieldName']])) {
            $this->is_valid = false;
            $this->errors[$rule['fieldName']] = "{$rule['fieldName']} field is required";

            return false;
        }
        elseif(false === $rule['required'] && empty($payload[$rule['fieldName']])){
          //If the field is optional do not check any other rule if user pass empty
          return false;
        }


        return true;
    }




    public function validateEmail($rule, $payload)
    {
      if( !(filter_var($payload[$rule['fieldName']], FILTER_VALIDATE_EMAIL)) ){
        $this->is_valid = false;
        $this->errors[$rule['fieldName']] = "{$rule['fieldName']} must be a valid email address";
      }
    }

    // Phone: only numbers,
    public function validateNumeric($rule, $payload){
       if( !is_numeric($payload[$rule['fieldName']])){
         $this->is_valid = false;
         $this->errors[$rule['fieldName']] = "{$rule['fieldName']} must be numeric";
       }
    }

    //Buyer: not more than 20 characters
    public function validateMaxCharacterLength($rule, $payload){
       if( !(strlen($payload[$rule['fieldName']]) <= $rule['max_length']) ){
         $this->is_valid = false;
         $this->errors[$rule['fieldName']] = "{$rule['fieldName']} character length should not exceed {$rule['max_length']}";
       }
    }
    // Note: anything, not more than 30 words,
    public function validateMaxWordLength($rule, $payload){
      $words = explode(' ', $payload[$rule['fieldName']]);

       if( !(count($words) <= $rule['max_length']) ){
         $this->is_valid = false;
         $this->errors[$rule['fieldName']] = "{$rule['fieldName']} words count should not exceed {$rule['max_length']}";
       }
    }

    //Buyer: only text, spaces and numbers
    public function validateAlphaNeumericSpace($rule, $payload){
       if( !(ctype_alnum(str_replace(' ', '', $payload[$rule['fieldName']]))) ){
         $this->is_valid = false;
         $this->errors[$rule['fieldName']] = "{$rule['fieldName']} can contain only alpha neumeric characters and space";
       }
    }
    // Receipt_id: only text
    public function validateAlpha($rule, $payload){
       if( !(ctype_alpha($payload[$rule['fieldName']])) ){
         $this->is_valid = false;
         $this->errors[$rule['fieldName']] = "{$rule['fieldName']} can contain only alpha characters";
       }
    }
    // Items: only text, user should be able to add multiple items
    public function validateAlphaCommaSpace($rule, $payload){
      $comma_space = array(',', ' ');
       if( !(ctype_alpha(str_replace($comma_space, '', $payload[$rule['fieldName']]))) ){
         $this->is_valid = false;
         $this->errors[$rule['fieldName']] = "{$rule['fieldName']} can contain alpha characters, comma and space";
       }
    }
    // City: only text and spaces.
    public function validateAlphaSpace($rule, $payload){
       if( !(ctype_alpha(str_replace(' ', '', $payload[$rule['fieldName']]))) ){
         $this->is_valid = false;
         $this->errors[$rule['fieldName']] = "{$rule['fieldName']} can contain only alpha characters and space";
       }
    }

    public function validateDate($rule){

      $format = 'Y-m-d';

      $d = DateTime::createFromFormat($format, $rule['value']);
      if(!($d && $d->format($format) === $rule['value'])){
        $this->is_valid = false;
        $this->errors[$rule['fieldName']] = "{$rule['fieldName']} should contain valid date";
      }

    }

}
