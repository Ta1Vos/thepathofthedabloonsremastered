<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Quest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('questText')
            ->add('dabloonReward')
            ->add('isCompleted')
            ->add('singleCompletion')
            ->add('rewardedItem', EntityType::class, [
                'class' => Item::class,
                'choice_label' => function (Item $entity) {
                    return $entity->getId() . ': ' . $entity->getName();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quest::class,
        ]);
    }
}
