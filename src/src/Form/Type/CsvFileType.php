<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class CsvFileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please select a CSV file.',
                        ]),
                        new File([
                            'maxSize' => '5M',
                            'mimeTypes' => [
                                'text/csv',
                                'application/csv',
                                'application/vnd.ms-excel',
                            ],
                        ]),
                    ],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => false,
        ]);
    }
}