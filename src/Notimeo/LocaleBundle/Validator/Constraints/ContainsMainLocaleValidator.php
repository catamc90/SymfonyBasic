<?php

namespace Notimeo\LocaleBundle\Validator\Constraints;

use Doctrine\ORM;
use Notimeo\LocaleBundle\Locale\EntityExt\Locales;
use Symfony\Component\Translation\DataCollectorTranslator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ContainsMainLocaleValidator
 *
 * @package Notimeo\LocaleBundle\Validator\Constraints
 */
class ContainsMainLocaleValidator extends ConstraintValidator
{
    /**
     * @var string
     */
    private $mainLocale;

    /**
     * @var DataCollectorTranslator
     */
    private $translator;

    /**
     * ContainsMainLocaleValidator constructor.
     *
     * @param string                  $mainLocale
     * @param DataCollectorTranslator $translator
     */
    public function __construct($mainLocale, DataCollectorTranslator $translator)
    {
        $this->mainLocale = $mainLocale;
        $this->translator = $translator;
    }

    /**
     * @param ORM\PersistentCollection $value
     * @param Constraint               $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $isValid = false;

        foreach($value as $item) {
            /* @var $item Locales */
            if($this->mainLocale === $item->getLang()) {
                $isValid = true;
                break;
            }
        }

        if(false === $isValid) {
            $translatedLang = $this->translator->trans('lang.'.$this->mainLocale);

            $this->context->buildViolation($constraint->message)
                ->setParameter('%lang%', $translatedLang)
                ->addViolation();
        }
    }
}