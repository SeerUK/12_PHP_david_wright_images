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
class GalleryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'attr' => array(
                    'placeholder' => 'Title'
                )
            ))
            ->add('subtitle', 'text', array(
                'attr' => array(
                    'placeholder' => 'Subtitle'
                )
            ))
            ->add('description', 'textarea', array(
                'attr' => array(
                    'placeholder' => 'Description...'
                )
            ))
            ->add('date', 'date', array(
                'format' => 'dd MMMM yyyy',
            ))
            ->add('submit', 'submit');
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DWI\PortfolioBundle\Entity\Gallery'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'dwi_portfoliobundle_gallery';
    }
}
