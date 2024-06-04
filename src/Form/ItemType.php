<?php

namespace App\Form;

use App\Entity\Effect;
use App\Entity\Item;
use App\Entity\Rarity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('isWeapon')
            ->add('description')
            ->add('rarity', EntityType::class, [
                'class' => Rarity::class,
                'choice_label' => 'name',
            ])
            ->add('effects', EntityType::class, [
                'class' => Effect::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
