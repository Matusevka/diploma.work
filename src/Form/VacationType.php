<?php

namespace App\Form;

use App\Entity\Vacations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\VacationStatus;
use App\Entity\User;

class VacationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_start')
            ->add('day_count')
            ->add('status',  EntityType::class, [
                            'class' => VacationStatus::class,
                            'choice_label' => 'name',
                        ])
            ->add('user', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'name',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vacations::class,
        ]);
    }
}
