<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Gallery Form Type
 */
class TagType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'Name'
                )
            ))
            ->add('description', 'text', array(
                'attr' => array(
                    'placeholder' => 'Description'
                )
            ))
            ->add('isPrimary', 'checkbox', array(
                'label'    => 'Is primary?',
                'required' => false,
            ))
            ->add('submit', 'submit');
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DWI\PortfolioBundle\Entity\Tag'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'dwi_portfoliobundle_tag';
    }
}
