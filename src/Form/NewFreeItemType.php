<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\FreeItem;
use App\Entity\FreePictures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewFreeItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, ['label' => false])

            ->add('description', TextareaType::class, ['label' => false])

            ->add(
                'category', EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name'
                ]
            )

            ->add('location', TextType::class, ['label' => false])
            
            ->add('addPost', SubmitType::class, ['label' => 'Add Post'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FreeItem::class,
        ]);
    }
}
