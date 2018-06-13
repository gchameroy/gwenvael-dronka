<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\PageStatic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageStaticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleSEO', TextType::class, [
                'label' => 'Titre SEO',
            ])
            ->add('descriptionSEO', TextType::class, [
                'label' => 'Description SEO',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PageStatic::class,
        ]);
    }
}
