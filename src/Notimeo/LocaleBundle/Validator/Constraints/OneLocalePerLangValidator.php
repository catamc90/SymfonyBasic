<?php

namespace Notimeo\LocaleBundle\Validator\Constraints;

use Doctrine\ORM;
use Notimeo\LocaleBundle\Locale\EntityExt\Locales;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class OneLocalePerLangValidator
 *
 * @package Notimeo\LocaleBundle\Validator\Constraints
 */
class OneLocalePerLangValidator extends ConstraintValidator
{
    /**
     * @param ORM\PersistentCollection $value
     * @param Constraint               $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $isValid        = true;
        $contentPerLang = [];

        foreach($value as $item) {
            /* @var $item Locales */
            if(!isset($contentPerLang[$item->getLang()])) {
                $contentPerLang[$item->getLang()] = 0;
            }

            $contentPerLang[$item->getLang()]++;

            if($contentPerLang[$item->getLang()] > 1) {
                $isValid = false;
                break;
            }
        }

        if(false === $isValid) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}