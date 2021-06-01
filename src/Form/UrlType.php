<?php

namespace App\Form;

use App\Entity\Url;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UrlType
 * @package App\Form
 */
class UrlType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('path', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control form-control-lg',
            ],
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Url::class,
            'attr' => [
                'class' => 'w-100 mt-3',
                'novalidate' => true,
            ],
        ]);
    }
}
