<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\FreeItem;
use App\Entity\FreeItemPictures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class EditFreeItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, ['label' => 'Title'])

            ->add('description', CKEditorType::class, [
                'label' => false,
                'config' => array(
                    'toolbar' => 'my_toolbar_1',
                ),
            ])

            ->add(
                'category', EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name'
                ]
            )

            ->add('location', TextType::class, ['label' => false])
            
            ->add('addPost', SubmitType::class, ['label' => 'Update Freebie'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FreeItem::class,
        ]);
    }
}
