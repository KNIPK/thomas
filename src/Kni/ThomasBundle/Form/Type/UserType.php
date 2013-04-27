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
            ->add('username', 'text', array('label' => "Login"))
            ->add('password', 'repeated', array(
                'first_name' => "password",
                'second_name' => "confirm_password",
                'type' => "password",
                'invalid_message' => 'Wpisane hasła muszą być takie same.',
                'first_options' => array("label" => "Hasło"),
                'second_options' => array("label" => "Powtórz hasło")
            ))
            ->add('name', 'text', array("label" => "Imię"))
            ->add('surname', 'text', array("label" => "Nazwisko"))
            ->add('email', 'email', array("label" => "E-mail"))
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
