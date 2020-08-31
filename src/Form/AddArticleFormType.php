<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Twig\Error\Error;

class AddArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,[
                'required'=>false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'vous devez renseigner un titre',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'le titre n\'est pas assez long!',
                        'max' => 4096,
                    ]),
                ],
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'ajouter un titre',
            ])
            ->add('content', TextareaType::class    ,
                [
                    'required'=>false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'vous devez écrire du contenu',
                        ]),
                        new Length([
                            'min' => 10,
                            'minMessage' => 'décrivez davantage cet article',
                            'max' => 4096,
                        ]),
                    ],
                    'label'=>'contenu de l\'article',
                    'attr'=>[
                        'class'=>'form-control mb-4'
                    ]
                ])
            ->add('picture',FileType::class,[
//                'label'=>'photo(url)',
                'mapped'=>false,
                'constraints'=>[
                    new File([
                        'maxSize'=>'1024k',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage'=>'ce format d\'image n\'est pas valide !',
                    ])
                ],
                'attr'=>[
                    'class'=>'mt-2 d-flex col btn darkThemeAlt text-left rounded p-2'
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
            'data_class' => Articles::class,
        ]);
    }
}
