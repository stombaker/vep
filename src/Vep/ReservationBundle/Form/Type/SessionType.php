<?php

namespace Vep\ReservationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vep\ReservationBundle\Service\Theater;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'datetime', array(
            'label' => 'Date',
            'format' => 'dd/mm/yyyy',
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ));
    }

    public function getName()
    {
        return 'form_session';
    }
    

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vep\ReservationBundle\Entity\Session'
        ));
    }
}