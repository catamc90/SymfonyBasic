<?php

namespace Notimeo\LocaleBundle\Locale\EntityExt;

use Doctrine\ORM;

/**
 * Class Locales
 *
 * @package Notimeo\LocaleBundle\Locale\EntityExt
 * @author  Krzysztof Trzos <k.trzos@notimeo.pl>
 */
class Locales
{
    /**
     * @var ORM\PersistentCollection
     */
    protected $locales;

    /**
     * @var string
     */
    protected $currLang;

    /**
     * @var string
     */
    protected $lang;

    /**
     * @param string $name
     * @return null
     */
    function __get($name)
    {
        $className       = get_class($this);
        $exploded        = explode('\\', $className);
        $localeClassName = $className.'\\'.array_pop($exploded).'Locale';

        if(property_exists($localeClassName, $name)) {
            return call_user_func([$this->getLocale(), 'get'.ucfirst($name)]);
        }

        return null;
    }

    /**
     * @param string $lang
     * @return mixed
     * @throws \Exception
     */
    public function getLocale($lang = '')
    {
        if('' === $lang) {
            $lang = $this->getCurrentLang();
        }

        foreach($this->locales as $locale) {
            if($locale->getLang() === $lang) {
                return $locale;
            }
        }

        throw new \Exception('No locale found in this language.');
    }

    /**
     * @return ORM\PersistentCollection
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     * @return string
     */
    public function getCurrentLang()
    {
        return $this->currLang;
    }

    /**
     * @param string $lang
     */
    public function setCurrentLang($lang)
    {
        $this->currLang = $lang;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }
}