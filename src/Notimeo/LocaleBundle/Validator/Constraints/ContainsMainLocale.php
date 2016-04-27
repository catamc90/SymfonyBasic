<?php

namespace Notimeo\LocaleBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ContainsMainLocale
 *
 * @Annotation
 * @package Notimeo\LocaleBundle\Validator\Constraints
 */
class ContainsMainLocale extends Constraint
{
    /**
     * @var string
     */
    public $message = 'You must provide content for main language (%lang%).';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'contains_main_locale';
    }
}