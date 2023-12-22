<?php

namespace App\Form;

use App\Entity\Habitant;
use App\Entity\Habitation;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HabitantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('DateDeNaissance', DateType::class, [
                'years' => range(date('Y') - 120, date('Y')),
                'months' => range(1, 12),
                'days' => range(1, 31),
                'format' => 'dd MM yyyy',])
          
            ->add('Genre')
            ->add('Modifier', ChoiceType::class, [
                'choices'  => [
                    
                    'l\'adresse de l\'habitation' => true,
                    'l\'adresse de l\'habitant' => false,
                ],
                'label' => 'Que voulez-vous modifier ?',
                'empty_data'=>true , 
                'mapped' => false,
            ])
            ->add('habitation', HabitationType::class)
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitant::class,
        ]);
    }
}
