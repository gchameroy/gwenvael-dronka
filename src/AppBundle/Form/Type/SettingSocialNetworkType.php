<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\SettingSocialNetwork;
use AppBundle\Entity\SocialNetwork;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingSocialNetworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', UrlType::class, [
                'label' => 'Lien url'
            ])
            ->add('socialNetwork', EntityType::class, [
                'label' => 'Réseau social',
                'class' => SocialNetwork::class,
                'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SettingSocialNetwork::class,
        ]);
    }
}
