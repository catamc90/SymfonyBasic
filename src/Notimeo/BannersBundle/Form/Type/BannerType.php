<?php
namespace Notimeo\BannersBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Class MyFileType
 *
 * @package Notimeo\BannersBundle\Form\Type
 * @author  Krzysztof Trzos <k.trzos@notimeo.pl>
 */
class BannerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', Type\TextType::class, [
            'label_attr' => ['class' => 'required label-required'],
        ]);
        $builder->add('isPublished');
        $builder->add('imageFile', VichImageType::class, [
            'label_attr'     => ['class' => 'required label-required'],
            'allow_delete'   => false,
        ]);
        $builder->add('alt', Type\TextType::class, [
            'label_attr' => ['class' => 'required label-required'],
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Notimeo\BannersBundle\Entity\Banner',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'notimeo_bannersbundle_banners';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'notimeo_bannersbundle_banners';
    }
}