<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginAt', DateTimeType::class, [
                'date_label' => 'Booking BeginAt',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-target' => '#booking_beginAt',
                    'data-toggle' => 'datetimepicker'
                ],
                'label' => 'Booking BeginAt',
                'required' => true
            ])
            ->add('endAt', DateTimeType::class, [
                'date_label' => 'Booking EndAt',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-target' => '#booking_endAt',
                    'data-toggle' => 'datetimepicker'
                ],
                'label' => 'Booking EndAt',
                'required' => false
            ])
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
