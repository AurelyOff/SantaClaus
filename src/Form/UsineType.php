<?php

namespace App\Form;

use App\Entity\Usine;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

class UsineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
        $builder->add('file', FileType::class, [
            'mapped' => false, 
            'required' => false, //to change ? 
            'constraints' => [
                new File([
                    'maxSize' => '1024k', 
                    'mimeTypes' => [
                        'text/plain',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid text document'
                ])
            ]
        ]);

        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usine::class,
        ]);
    }
}
