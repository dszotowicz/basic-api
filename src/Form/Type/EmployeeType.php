<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Employee;
use App\Glossary\PositionType;
use App\Subscriber\UniqueEmployeeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmployeeType extends AbstractType
{
    /**
     * @var UniqueEmployeeSubscriber
     */
    private $uniqueSubscriber;

    public function __construct(UniqueEmployeeSubscriber $uniqueSubscriber)
    {
        $this->uniqueSubscriber = $uniqueSubscriber;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Length([
                    'max' => 64
                ])
            ]
        ]);
        $builder->add('lastName', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Length([
                    'max' => 64
                ])
            ]
        ]);
        $builder->add('position', ChoiceType::class, [
            'choices' => PositionType::getConstantValues()
        ]);
        $builder->add('phoneNumber', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Length([
                    'max' => 16
                ])
            ]
        ]);
        $builder->addEventSubscriber($this->uniqueSubscriber);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
            'csrf_protection' => false
        ]);
    }
}