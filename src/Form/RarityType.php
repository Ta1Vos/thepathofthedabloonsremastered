<?php

namespace App\Form;

use App\Entity\Rarity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RarityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'empty_data' => ' ',
            ])
            ->add('priority', NumberType::class, [
                'help_html' => true,
                'help' => "Priority = The lowest number will be used first. Example: If Common(1) fails, it will try Uncommon(2), then Rare(3), etc. <br> 
                    <small>Negative numbers will <b>NOT</b> be part of the priority system and can be used to exclude rarities from naturally obtaining.</small>"
            ])
            ->add('chanceIn', null, [
                'label' => 'Chance in',
                'help' => '(... in 100)'
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
