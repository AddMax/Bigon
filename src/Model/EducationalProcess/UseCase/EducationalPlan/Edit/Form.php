<?php

namespace App\Model\EducationalProcess\UseCase\EducationalPlan\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Model\EducationalProcess\Entity\EducationalPlan\FormEducation;
use App\Model\EducationalProcess\Entity\EducationalPlan\Status;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('specialty', Type\TextType::class, ['label' => 'Специальность'])
            ->add('direction', Type\TextType::class, ['label' => 'Направление специальности'])
            ->add('specialization', Type\TextType::class, ['label' => 'Специализация'])
            ->add('qualification', Type\TextType::class, ['label' => 'Квалификация специалиста'])
            ->add('formEducation', Type\ChoiceType::class, [
                'label' => 'Форма получения образования',
                'choices' => [array_flip(FormEducation::NAME)],
                'group_by' => 'Форма получения образования',
                'placeholder' => '- Выбрать -',
            ])
            ->add('status', Type\ChoiceType::class, [
                'label' => 'Статус',
                'choices' => [
                    Status::ACTIVE,
                    Status::ARCHIVED
                ],
                'group_by' => 'Статус',
                'placeholder' => '- Выбрать -',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
