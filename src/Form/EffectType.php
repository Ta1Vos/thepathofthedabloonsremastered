<?php

namespace App\Form;

use App\Entity\Effect;
use App\Entity\Event;
use App\Entity\Item;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EffectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('debuffSeverity')
            ->add('debuffDuration', null, [
                'label' => 'Debuff duration (amount of events passed)'
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
