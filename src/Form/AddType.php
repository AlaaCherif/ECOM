<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,[
                'attr'=>[
                    'style'=>'margin:5px',
                    'class'=>'form-control'
                ]
            ])
            ->add('description',null,[
                'attr'=>[
                    'style'=>'margin:5px',
                    'class'=>'form-control'
                ]
            ])
            ->add('price',null,[
                'attr'=>[
                    'style'=>'margin:5px',
                    'class'=>'form-control'
                ]
            ])
            ->add('image',FileType::class,[
                'attr'=>[
                    'style'=>'margin:5px',
                    'class'=>'form-control'
                ],
                'mapped'=>false,
                'required'=>true
            ])
            ->add('recommended',CheckboxType::class,[
                'attr'=>[
                    'class'=>'form-check-input'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'style'=>'margin:5px',
                    'class'=>'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
