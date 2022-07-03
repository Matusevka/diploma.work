<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Tickspot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\CallbackTransformer;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'email'])
            ->add('name', TextType::class, ['label' => 'Имя'])
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Пользователь' => 'ROLE_USER',
                    'Администратор' => 'ROLE_ADMIN',
                ],
            ])
            //->add('git_token', TextType::class, ['label' => 'Гит токен'])
            //->add('git_username', TextType::class, ['label' => 'Гит токен'])
            ->add('tickspot', EntityType::class, [
                    'class' => Tickspot::class,
                    'choice_label' => 'last_name',
                    'label' => 'Пользователь TICK'
            ])
            ->add('github_login', TextType::class, ['label' => 'Логин Github'])  
            ->add('password', PasswordType::class, ['label' => 'Пароль', 'required' => false]);
        
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                     // transform the array to a string
                     return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                     // transform the string back to an array
                     return [$rolesString];
                }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
