<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
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
                    'style'=>'margin:5px'
                ]
            ])
            ->add('description',null,[
                'attr'=>[
                    'style'=>'margin:5px'
                ]
            ])
            ->add('price',null,[
                'attr'=>[
                    'style'=>'margin:5px'
                ]
            ])
            ->add('image',null,[
                'attr'=>[
                    'style'=>'margin:5px'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'style'=>'margin:5px'
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
