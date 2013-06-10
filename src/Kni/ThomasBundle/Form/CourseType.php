<?php

namespace Kni\ThomasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array("label" => "Nazwa kursu"))
            ->add('startDate', 'datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'label' => "Rozpoczęcie"
            ))
            ->add('endDate', 'datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'label' => "Zakończenie"
            ))
            ->add('description', 'textarea', array(
                'attr' => array('cols' => 46, 'rows' => 5),
                'label' => "Opis",
                'required' => false
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kni\ThomasBundle\Entity\Course'
        ));
    }

    public function getName()
    {
        return 'kni_thomasbundle_coursetype';
    }
}
