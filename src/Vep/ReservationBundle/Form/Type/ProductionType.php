<?php

namespace Vep\ReservationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vep\ReservationBundle\Service\Theater;

class ProductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('label' => 'Titre'))
                ->add('content', 'textarea', array('label' => 'Description'))
                ->add('file', 'file', array('label' => 'Poster', 'required' => false))
                ->add('sessions', 'collection', array(
                    'type' => new SessionType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ))
                ->add('save', 'submit', array('label' => 'Envoyer'));
    }

    public function getName()
    {
        return 'form_production';
    }
    

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vep\ReservationBundle\Entity\Production'
        ));
    }
}