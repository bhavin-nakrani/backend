<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['data'];

        $builder
            ->add('email', EmailType::class, ['required' => true, 'label' => 'Email Address'])
            ->add('userRole', EntityType::class, [
                'class' => Role::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'User Role',
                'placeholder' => 'Please select',
                'required' => true,
                'constraints' => new NotBlank(),
            ])
            ->add('password', PasswordType::class, ['label' => 'Password'])
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => new NotBlank(),
                'label' => 'Name',
            ])
            ->add('photo', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Photo',
                'constraints' => [
                    new File([
                        'maxSize' => '10m',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file upto 10m',
                    ]),
                ],
            ])
            ->add('phone', TextType::class, ['label' => 'Phone'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
