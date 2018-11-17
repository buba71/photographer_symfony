<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'constraints' => array(
                    new NotBlank(),
                    new Length(array(
                        'min' => 3,
                        'minMessage' => 'Votre nom n\'est pas valide'
                    ))
                )
            ))
            ->add('firstName', TextType::class, array(
                'constraints' => array(
                    new NotBlank(),
                    new Length(array(
                        'min' => 3,
                        'minMessage' => 'Votre prénom n\'est pas valide'
                        ))
                )
            ))
            ->add('email', EmailType::class, array(
                'constraints' => array(
                    new Email()
                )
            ))
            ->add('message', TextareaType::class, array(
                'constraints' => array(
                    new NotBlank()
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
