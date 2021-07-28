<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', Type\TextType::class, [
                'label' => 'Имя учетной записи',
                'required' => true,
            ])
            ->add('email', Type\EmailType::class, [
                'label' => 'Email',
                'required' => true,
            ])
            ->add('password', Type\PasswordType::class, [
                'label' => 'Пароль',
                'mapped' => false,
                'required' => false,
            ])
            ->add('check', Type\CheckboxType::class, [
                'label'    => 'Подтвердить замену пароля',
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
