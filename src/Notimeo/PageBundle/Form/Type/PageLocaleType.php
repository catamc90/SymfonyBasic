<?php
namespace Notimeo\PageBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * Class PageLocaleType
 *
 * @package Notimeo\PageBundle\Form\Type
 * @author  Krzysztof Trzos <k.trzos@notimeo.pl>
 */
class PageLocaleType extends AbstractType
{
    /**
     * @var array
     */
    private $locales = [];

    /**
     * PageLocaleType constructor.
     *
     * @param $locales
     */
    public function __construct($locales)
    {
        $this->locales = $locales;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $langsChoices = [];

        foreach($this->locales as $locale) {
            $langsChoices['lang.'.$locale] = $locale;
        }

        $builder->add('lang', Type\ChoiceType::class, ['required' => true, 'choices' => $langsChoices]);
        $builder->add('title', Type\TextType::class, ['required' => true]);
        $builder->add('content', CKEditorType::class);
        $builder->add('imageFile', VichImageType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Notimeo\PageBundle\Entity\Page\PageLocale',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'notimeo_pagebundle_pagelocale';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'notimeo_pagebundle_pagelocale';
    }
}