<?php

namespace App\Form;

use App\Entity\Effect;
use App\Entity\Event;
use App\Entity\Item;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EffectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'empty_data' => ' ',
            ])
            ->add('affectedPlayerProperty', ChoiceType::class, [
                'help' => "The player property that you wish to edit",
                'choices' => [
                    'health' => 'health',
                    'dabloons' => 'dabloons',
                    'distance' => 'distance',
                    'inventoryMax' => 'inventoryMax',
                ]
            ])
            ->add('effectValueSeverity', null, [
                'label' => 'Effect Severity',
                'help' => "How much does the Player Property get affected? (Can be negative/positive)",
                'attr' => [
                    'value' => 0
                ]
            ])
            ->add('debuffDuration', null, [
                'label' => 'Debuff duration (amount of events passed)',
                'attr' => [
                    'value' => 1
                ],
                'help' => "The effect will affect the player every event. Example: 2 event duration, 2 dabloons, in total 4 dabloons."
            ])
            ->add('items', EntityType::class, [
                'class' => Item::class,
                'choice_label' => function (Item $entity) {
                    return $entity->getId() . ': ' . $entity->getName();
                },
                'multiple' => true,
            ])
            ->add('events', EntityType::class, [
                'class' => Event::class,
                'choice_label' => function (Event $entity) {
                    return $entity->getId() . ': ' . $entity->getName();
                },
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Effect::class,
        ]);
    }
}
