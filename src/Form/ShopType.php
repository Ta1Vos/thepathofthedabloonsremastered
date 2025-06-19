<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Rarity;
use App\Entity\Shop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'empty_data' => ' ',
            ])
            ->add('additionalLuck')
            ->add('additionalPrice')
            ->add('itemAmount')
            ->add('rarity', EntityType::class, [
                'class' => Rarity::class,
                'choice_label' => function (Rarity $entity) {
                    return $entity->getId() . ': ' . $entity->getName();
                },
                'placeholder' => 'none'
            ])
            ->add('guaranteedItems', EntityType::class, [
                'class' => Item::class,
                'choice_label' => function (Item $entity) {
                    return $entity->getId() . ': ' . $entity->getName();
                },
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}
