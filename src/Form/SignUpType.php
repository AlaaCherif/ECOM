<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                "attr"=>[
                    "class"=>"form-control",
                ]
            ])
            ->add('password',PasswordType::class,[
                "attr"=>[
                    "class"=>"form-control",
                    "id"=>"floatingInput"
                ]
            ])
            ->add('name',null,[
                "attr"=>[
                    "class"=>"form-control",
                ]
            ])
            ->add('last_name',null,[
                "attr"=>[
                    "class"=>"form-control",
                ]
            ])
            ->add('birth_date',TypeDateType::class,[
                "attr"=>[
                    "class"=>"form-control",
                ]
            ])
            ->add('address',null,[
                "attr"=>[
                    "class"=>"form-control",
                ]
            ])
            ->add('submit',SubmitType::class,[
                "attr"=>[
                    "class"=>"btn btn-primary btn-lg",
                    "style"=>"margin-top:5px"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
