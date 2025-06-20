<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Option;
use App\Entity\Quest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'empty_data' => ' ',
            ])
            ->add('events', EntityType::class, [
                'class' => Event::class,
                'choice_label' => function (Event $entity) {
                    return $entity->getId() . ': ' . $entity->getName();
                },
                'multiple' => true,
            ])
            ->add('quests', EntityType::class, [
                'class' => Quest::class,
                'choice_label' => function (Quest $entity) {
                    return $entity->getId() . ': ' . $entity->getName();
                },
                'label' => 'Quest',
                'placeholder' => 'none'
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
