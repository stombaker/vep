<?php

namespace Vep\ReservationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vep\ReservationBundle\Service\Theater;

class ReservationType extends AbstractType
{
    private $theater;
    
    public function __construct(Theater $theater) {
        $this->theater = $theater;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'text', array('label' => 'Prénom'))
                ->add('lastname', 'text', array('label' => 'Nom'))
                ->add('city', 'text', array('label' => 'Ville', 'required' => false))
                ->add('comment', 'textarea', array('label' => 'Commentaire', 'required' => false))
                ->add('email', 'email', array('label' => 'Adresse e-mail'))
                ->add('seats', 'choice', array('choices' => $this->theater->getFreeSeatList($options['session']), 'multiple' => true, 'expanded' => true))
                ->add('save', 'submit', array('label' => 'Réserver'));
    }

    public function getName()
    {
        return 'form_reservation';
    }
    

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vep\ReservationBundle\Entity\Reservation',
            'session' => null
        ));
    }
}