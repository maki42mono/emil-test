<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\ClientException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\TraceableValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GroupSequence;

class APIValidator extends TraceableValidator
{
    /**
     * @throws ClientException
     */
    public function validate(
        mixed $value,
        Constraint|array|null $constraints = null,
        string|GroupSequence|array|null $groups = null
    ): ConstraintViolationListInterface {
        $violations = parent::validate($value);
        if (count($violations) > 0) {
            $errorMessages = [];
            foreach ($violations as $violation) {
                $errorMessages[$violation->getPropertyPath()] = $violation->getMessage();
            }
            throw new ClientException('', ClientException::REQUEST_DATA, $errorMessages);
        }

        return $violations;
    }
}