<?php

namespace BoutiqueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints as Assert;



class MembreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pseudo', TextType::class, array( 
                    'required'      => false,
                    'constraints'    => array(
                        new Assert\NotBlank(array(
                            'message' => 'veuillez renseigner votre pseudo'
                        )),
                        new Assert\Length(array(
                            'min'           => 3,
                            'minMessage'    => 'Votre pseudo doit contenir 3 caractères minimum',
                            'max'           => 20,
                            'maxMessage'    => 'Votre pseudo doit contenir 20 caractères maximium'
                        )),
                        new Assert\Regex(array(
                            'pattern'   => '/^[a-zA-Z-._0-9]+$/',
                            'message'   => 'Le pseudo accepte les lettres et les chiffres'
                        ))
                    )    
                ))
                ->add('mdp', PasswordType::class)
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('email', TextType::class)
                ->add('civilite', ChoiceType::class,array(
                            'choices' => array(
                                'Votre civilité' => '',
                                'Homme' => 'm',
                                'Femme' => 'f'
                            )
                        ))
                ->add('ville', TextType::class)
                ->add('codePostal', TextType::class, array(
                    'required'      => false,
                    'constraints'   => array(
                        new Assert\NotBlank,
                        new Assert\Type(array(
                            'type'      => 'integer',
                            'message'   => 'Votre message doit être composé de 5 chiffre'
                        ))
                        ),
                        'attr'      => array(
                            'placeholder'   => 'ex: 75001',
                            'class'         => 'form-control'
                        )
                ))
                ->add('adresse', TextType::class)
                ->add('statut', IntegerType::class)
                ->add('save', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BoutiqueBundle\Entity\Membre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'boutiquebundle_membre';
    }


}
