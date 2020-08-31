<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;


class AddJournalistFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'required'=>false,
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'renseignez un email',
            ])
            ->add('lastname', TextType::class    ,
                [
                    'required'=>false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'vous devez renseigner un nom',
                        ]),
                        new Length([
                            'min' => 3,
                            'minMessage' => 'votre nom doit contenir au minimum trois caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label'=>'nom du journaliste',
                    'attr'=>[
                        'class'=>'form-control mb-4'
                    ]
                ])
            ->add('firstname', TextType::class,
                [
                    'required'=>false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'vous devez renseigner un prénom',
                        ]),
                        new Length([
                            'min' => 3,
                            'minMessage' => 'votre prénom doit contenir au minimum trois caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label'=>'prénom du journaliste',
                    'attr'=>[
                        'class'=>'form-control mb-4'
                    ]
                ])
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'required'=>false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'renseignez votre mot de passe',
                    ]),
                    new Regex([
                        'pattern'=>'/^(?=.*[a-z])(?=.*[0-9])(?=.{8,})/',
                        'message'=>'votre mot de passe doit contenir au minimum une lettre et un chiffre',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'votre mot de passe doit contenir 8 caractères au minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'attr'=>[
                    'class'=>'form-control mb-4'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'attr'=> [
                    'class'=>'btn btn-info rounded d-flex text-dark mt-3 mb-2'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
