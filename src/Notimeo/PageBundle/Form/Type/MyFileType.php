<?php
namespace Notimeo\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Vich\UploaderBundle\Form\Type\VichFileType;

/**
 * Class MyFileType
 *
 * @package Notimeo\PageBundle\Form\Type
 * @author  Krzysztof Trzos <k.trzos@notimeo.pl>
 */
class MyFileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', Type\TextType::class, ['required' => true]);
        $builder->add('contractFile', VichFileType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Notimeo\PageBundle\Entity\Page\PageFile',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'notimeo_pagebundle_pagefile';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'notimeo_pagebundle_pagefile';
    }
}