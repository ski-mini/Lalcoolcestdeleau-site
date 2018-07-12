<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Entity\Deck;

class DeckForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                                                'label' => 'Nom',
                                                'required'   => true,
                                            ))
            ->add('keyword', TextType::class, array('label' => 'Mots clefs'))
            ->add('description', TextareaType::class, array('label' => 'Description'))
            ->add('visibility', EntityType::class, array(   
                                                            'label' => 'Visibilité',
                                                            'required' => true, 
                                                            'class' => 'AppBundle:Deckvisibility', 
                                                            'choice_label' => 'name' 
                                                        ))
            ->add('save', SubmitType::class, array(
                                                'label' => 'Enregistrer', 
                                                'attr' => array('class' => 'btn-success btn-lg btn-block'),
                                            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Deck::class,
        ));
    }
}