<?php

namespace App\Form;

use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['required' => true, 'label' => 'Role Name'])
            ->add('isAdd', CheckboxType::class, ['label' => 'Is Add'])
            ->add('isEdit', CheckboxType::class, ['label' => 'Is Edit'])
            ->add('isDelete', CheckboxType::class, ['label' => 'Is Delete'])
            ->add('isView', CheckboxType::class, ['label' => 'Is View'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
        ]);
    }
}
