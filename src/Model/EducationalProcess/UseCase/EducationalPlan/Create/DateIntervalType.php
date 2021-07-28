<?php

namespace App\Model\EducationalProcess\UseCase\EducationalPlan\Create;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateIntervalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_date', Type\DateType::class, [
                'label' => 'first_date',
                'widget' => 'single_text',
                // 'format' => 'dd-MM-yyyy',
                'row_attr' => ['class' => 'col-md-2']
                ])
            ->add('second_date', Type\DateType::class, [
                'label' => 'second_date',
                'widget' => 'single_text',
                // 'format' => 'dd-MM-yyyy',
                'row_attr' => ['class' => 'col-md-2']
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => ['class' => 'form-row'],
        ]);

    }

}
