<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Price;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'scale' => 0,
            ])
            ->add('label', TextType::class, [
                'label' => 'Label',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('content', CKEditorType::class, [
                'config_name' => 'my_config',
                'label' => 'Contenu',
                'required' => false,
            ])
            ->add('offer', CheckboxType::class, [
                'label' => 'Offre combinée ?',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Price::class,
        ]);
    }
}
