<?php

namespace Vep\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vep\ReservationBundle\Service\Theater;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('label' => 'Titre'))
                ->add('content', 'textarea', array('label' => 'Description'))
                ->add('menuOrder', 'integer', array('label' => 'Ordre du menu (vide si pas dans le menu)', 'required' => false))
                ->add('save', 'submit', array('label' => 'Envoyer'));
    }

    public function getName()
    {
        return 'form_page';
    }
    

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vep\PageBundle\Entity\Page'
        ));
    }
}