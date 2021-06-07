<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\Setting;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('appName', TextType::class, ['label' => 'Application Name'])
            /*->add('smtpUser', TextType::class, ['label' => 'SMTP Username'])
            ->add('smtpPassword', TextType::class, ['label' => 'SMTP Password'])
            ->add('smtpHost', TextType::class, ['label' => 'SMTP Host name'])
            ->add('smtpPort', TextType::class, ['label' => 'SMTP Port'])*/
            ->add('userRole', EntityType::class, [
                'class' => Role::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Default User Registration Role',
                'placeholder' => 'Please select',
                'required' => false,
            ])
            ->add('isArticlePublish', CheckboxType::class, ['label' => 'Is Article publish by default?'])
            ->add('isLoginUserAuthor', CheckboxType::class, ['label' => 'Is Login user set by default for new article?'])
            ->add('pageSize', ChoiceType::class, [
                'choices' => [
                    '10' => 10,
                    '25' => 25,
                    '50' => 50,
                    '100' => 100,
                ],
                'label' => 'Page Size',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Setting::class,
        ]);
    }
}
