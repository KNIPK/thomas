<?php

namespace Kni\ThomasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie')
            ->add('nazwisko')
            ->add('wiek')
            ->add('endDate', 'datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'label'=> 'Jakaś data'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kni\ThomasBundle\Entity\Test'
        ));
    }

    public function getName()
    {
        return 'kni_thomasbundle_testtype';
    }
}
