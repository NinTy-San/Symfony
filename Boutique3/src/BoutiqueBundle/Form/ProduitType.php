<?php

namespace BoutiqueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints as Assert;



class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('reference', TextType::class, array(
                        'required'      => false,
                        'constraints'   => array(
                            new Assert\NotBlank,
                        )
                    ))
                ->add('categorie', TextType::class, array(
                        'required'      => false,
                        'constraints'   => array(
                            new Assert\NotBlank,
                        )
                    ))
                ->add('titre', TextType::class, array(
                        'required'      => false,
                        'constraints'   => array(
                            new Assert\NotBlank,
                        )
                    ))
                ->add('description',  TextType::class, array(
                        'required'      => false,
                        'constraints'   => array(
                            new Assert\NotBlank,
                        )
                    ))
                ->add('couleur',  TextType::class, array(
                        'required'      => false,
                        'constraints'   => array(
                            new Assert\NotBlank,
                        )
                    ))
                ->add('taille',  TextType::class, array(
                        'required'      => false,
                        'constraints'   => array(
                            new Assert\NotBlank,
                        )
                    ))
                ->add('public', ChoiceType::class,array(
                            'choices' => array(
                                'Votre civilité' => '',
                                'Homme' => 'm',
                                'Femme' => 'f'
                            )
                        ))
                ->add('file',  FileType::class, array(
                        'required'      => false
                    ))
                ->add('prix', MoneyType::class)
                ->add('stock', IntegerType::class)
                ->add('save', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BoutiqueBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'boutiquebundle_produit';
    }


}
