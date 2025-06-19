<?php

namespace App\Form;

use App\Entity\Effect;
use App\Entity\Item;
use App\Entity\Rarity;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'empty_data' => ' ',
            ])
            ->add('price')
            ->add('isWeapon', CheckboxType::class, [
                'required' => false,
                'label' => 'Is Weapon'
            ])
            ->add('defeatChance')
            ->add('description', TextareaType::class, [
                'required' => true,
                'empty_data' => ' ',
            ])
            ->add('rarity', EntityType::class, [
                'class' => Rarity::class,
                'choice_label' => function (Rarity $entity) {
                    return $entity->getId() . ': ' . $entity->getName();
                },
                'placeholder' => 'none'
            ])
            ->add('effects', EntityType::class, [
                'class' => Effect::class,
                'choice_label' => function (Effect $entity) {
                    return $entity->getId() . ': ' . $entity->getName();
                },
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
