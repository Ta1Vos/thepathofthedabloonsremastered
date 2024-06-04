<?php

namespace App\Form;

use App\Entity\Dialogue;
use App\Entity\Effect;
use App\Entity\Event;
use App\Entity\Option;
use App\Entity\World;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('eventText')
            ->add('name')
            ->add('effects', EntityType::class, [
                'class' => Effect::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('dialogues', EntityType::class, [
                'class' => Dialogue::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('worlds', EntityType::class, [
                'class' => World::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
