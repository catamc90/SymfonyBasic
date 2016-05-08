<?php

namespace Notimeo\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target("CLASS")
 */
class FileNotEmpty extends Constraint
{
    /**
     * @var string
     */
    public $message = 'This field cannot be empty.';

    /**
     * @var array
     */
    public $fields = [];

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}