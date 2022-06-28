<?php

namespace App\Validator\Exception;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidatorException as SymfonyValidatorException;

class ValidatorException extends SymfonyValidatorException
{
    private $errors;

    public function __construct(ConstraintViolationList $errors, string $message = '')
    {
        parent::__construct($message);

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        $errors = [];

        foreach ($this->errors as $error) {
            $errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errors;
    }
}
