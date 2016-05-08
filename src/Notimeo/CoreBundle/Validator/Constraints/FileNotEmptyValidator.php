<?php

namespace Notimeo\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class FileNotEmptyValidator
 *
 * @package Notimeo\CoreBundle
 */
class FileNotEmptyValidator extends ConstraintValidator
{
    /**
     * @param mixed      $protocol
     * @param Constraint $constraint
     */
    public function validate($protocol, Constraint $constraint)
    {
        /* @var $constraint FileNotEmpty */
        foreach($constraint->fields as $field) {
            $method1 = 'get'.ucfirst($field);
            $method2 = $method1.'File';

            $value1 = call_user_func([$protocol, $method1]);
            $value2 = call_user_func([$protocol, $method2]);

            if(empty($value1) && empty($value2)) {
                $this->context->buildViolation($constraint->message)
                    ->atPath($field.'File')
                    ->addViolation();
            }
        }
    }
}