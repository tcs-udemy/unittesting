<?php
namespace Acme\Validation;

use Acme\Http\Response;
use Acme\Http\Session;
use Respect\Validation\Validator as Valid;

/**
 * Class Validator
 * @package Acme\Validation
 */
class Validator {

    /**
     * @var Session
     */
    protected $session;
    /**
     * @var
     */
    protected $isValid;

    protected $response;

    /**
     *
     */
    public function __construct($response)
    {
        $this->session = new Session();
        $this->response = $response;
    }

    /**
     * @param $validation_data
     * @return array
     */
    public function check($validation_data)
    {

        $errors = [];

        foreach ($validation_data as $name => $value) {

            $rules = explode("|", $value);

            foreach ($rules as $rule) {
                $exploded = explode(":", $rule);

                switch ($exploded[0]) {
                    case 'min':
                        $min = $exploded[1];
                        if (Valid::string()->length($min)->Validate($_REQUEST[$name]) == false) {
                            $errors[] = $name . " must be at least " . $min . " characters long!";
                        }
                        break;

                    case 'email':
                        if (Valid::email()->Validate($_REQUEST[$name]) == false) {
                            $errors[] = $name . " must be a valid email!";
                        }
                        break;

                    case 'equalTo':
                        if (Valid::equals($_REQUEST[$name])->Validate($_REQUEST[$exploded[1]]) == false) {
                            $errors[] = "Value does not match verification value!";
                        }
                        break;

                    case 'unique':
                        $model = "Acme\\models\\" . $exploded[1];
                        $table = new $model;
                        $results = $table::where($name, '=', $_REQUEST[$name])->get();
                        foreach ($results as $item) {
                            $errors[] = $_REQUEST[$name] . " already exists in this system!";
                        }
                        break;

                    default:
                        $errors[] = "No value found!";
                }
            }
        }

        return $errors;

    }


    /**
     * @param $rules
     * @return bool
     */
    public function validate($rules, $url)
    {
        $errors = $this->check($rules);

        if (sizeof($errors) > 0) {
            $this->session->put('_error', $errors);
            $this->isValid = false;

            return $this->response->redirectTo($url);
            exit;
        } else {
            $this->isValid = true;

            return true;
        }
    }


    /**
     * @return mixed
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * @param mixed $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

}
