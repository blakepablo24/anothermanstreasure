<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditUserDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('name', TextType::class)
            ->add('last_name', TextType::class)
            ->add('number', TextType::class)
            ->add('address_line_1', TextType::class)
            ->add('address_line_2', TextType::class)
            ->add('address_line_3', TextType::class)
            ->add('address_area', TextType::class)
            ->add('address_post_code', TextType::class)
            ->add('submitChanges', SubmitType::class, ['label' => 'Submit Changes'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
