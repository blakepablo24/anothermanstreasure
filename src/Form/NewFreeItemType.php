<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\FreeItem;
use App\Entity\FreePictures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class NewFreeItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, ['label' => false])

            ->add('description', CKEditorType::class, [
                'label' => false,
                'config' => array(
                    'toolbar' => 'my_toolbar_1',
                    'extraPlugins' => 'confighelper',
                    'placeholder' => 'Item Description Here ...',
                ),
                'plugins' => array(
                    'confighelper' => array(
                        'path' => '/bundles/confighelper/',
                        'filename' => 'plugin.js',
                    ),
                )
            ])

            ->add(
                'category', EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name'
                ]
            )

            ->add('picture01', FileType::class, [
                'label' => 'Main Picture',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image must be Jpeg/Png no more than 5mb',
                    ])
                ],
            ])

            ->add('picture02', FileType::class, [
                'label' => 'Picture 2',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image must be Jpeg/Png no more than 5mb',
                    ])
                ],
            ])

            ->add('picture03', FileType::class, [
                'label' => 'Picture 3',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image must be Jpeg/Png no more than 5mb',
                    ])
                ],
            ])

            ->add('picture04', FileType::class, [
                'label' => 'Picture 4',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image must be Jpeg/Png no more than 5mb',
                    ])
                ],
            ])

            ->add('picture05', FileType::class, [
                'label' => 'Picture 5',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image must be Jpeg/Png no more than 5mb',
                    ])
                ],
            ])

            ->add('picture06', FileType::class, [
                'label' => 'Picture 6',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image must be Jpeg/Png no more than 5mb',
                    ])
                ],
            ])

            ->add('location', TextType::class, ['label' => 'false', 'required' => true])
            
            ->add('addPost', SubmitType::class, ['label' => 'Add Free Item'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FreeItem::class,
        ]);
    }
}
