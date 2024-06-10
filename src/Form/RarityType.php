<?php

namespace App\Form;

use App\Entity\Rarity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RarityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('chanceIn', null, [
                'label' => 'Chance in',
                'help' => '{Chance}% in 100%'
            ])
            ->add('priority', NumberType::class, [
                'help' => 'Priority = The lowest number will be used first. Example: If Common(1) fails, it will try Uncommon(2), then Rare(3), etc..'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rarity::class,
        ]);
    }
}
