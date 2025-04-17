<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Status;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' =>'form-control my-2', 'placeholder'=>'Product Name'],
                'required' => true,
                ] )
            ->add('price', MoneyType::class, [
                'currency' => 'EUR', 
                'attr' => ['class' =>'form-control my-2', 'placeholder'=>'Product Price'],
                'required' => true
                ] )
            ->add('description', TextType::class, [
                'attr' => ['class' =>'form-control my-2', 'placeholder'=>'Product Description'],
                'required' => true
                ] )
            ->add('status_type', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'status_type',
                'attr' => ['class' =>'form-control my-2'],
            ])
            ->add('supplier', EntityType::class, [
                'class' => Supplier::class,
                'choice_label' => 'name',
                'attr' => ['class' =>'form-control my-2']
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'image file product',
                'attr' => ['class'=> 'form-control my-2'],
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
