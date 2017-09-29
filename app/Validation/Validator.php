<?php
/**
 *
 */

namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

use Slim\Http\Request;

class Validator
{
    /**
     * @var
     */
    protected $errors = [];

    public function validate(Request $request, array $rules)
    {
        foreach($rules as $field => $rule){
            try{
                $rule->setName($field)
                    ->assert($request->getParam($field));
            }catch (NestedValidationException $e){
                $this->errors[$field] = $e->getMessages();
            }
        }

        // attach errors into session
        $_SESSION['errors'] = $this->errors;

       return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }
}