<?php

namespace Kni\ThomasBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', 'repeated', array(
                'first_name' => "password",
                'second_name' => "confirm_password",
                'type' => "password"
            ))
            ->add('name')
            ->add('surname')
            ->add('email')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kni\ThomasBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'kni_thomasbundle_usertype';
    }
}
