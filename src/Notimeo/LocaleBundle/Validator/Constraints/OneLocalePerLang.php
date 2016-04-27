<?php

namespace Notimeo\LocaleBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ContainsMainLocale
 *
 * @Annotation
 * @package Notimeo\LocaleBundle\Validator\Constraints
 */
class OneLocalePerLang extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Only one set of content can be assigned to one language.';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'one_locale_per_lang';
    }
}