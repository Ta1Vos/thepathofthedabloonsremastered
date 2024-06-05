<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Option;
use App\Entity\Quest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('events', EntityType::class, [
                'class' => Event::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('quests', EntityType::class, [
                'class' => Quest::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Option::class,
        ]);
    }
}
