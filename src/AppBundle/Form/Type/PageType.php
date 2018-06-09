<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('titleSeo', TextType::class, [
                'label' => 'Titre SEO',
                'required' => false,
            ])
            ->add('descriptionSeo', TextType::class, [
                'label' => 'Description SEO',
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de fond',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
