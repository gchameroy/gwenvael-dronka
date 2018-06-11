<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\PageBlock;
use AppBundle\Entity\PageBlockAction;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('content', CKEditorType::class, [
                'config_name' => 'my_config',
                'label' => 'Contenu',
            ])
            ->add('action', EntityType::class, [
                'label' => 'Action',
                'class' => PageBlockAction::class,
                'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PageBlock::class,
        ]);
    }
}
