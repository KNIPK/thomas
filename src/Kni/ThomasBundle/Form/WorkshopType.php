<?php

namespace Kni\ThomasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class WorkshopType extends AbstractType
{
    protected $user;
    
    public function __construct($user) {
        $this->user = $user;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->user;
        $builder
            ->add('name', 'text', array("label" => "Nazwa"))
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
                'label' => "Opis"
            ))
            ->add('course', 'entity', array(
                'class' => 'KniThomasBundle:Course',
                'property' => 'name',
                'label' => 'Kurs',
                'query_builder' => function(EntityRepository $er) use($user){
                    return $er->createQueryBuilder('c')->where('c.user = :user')->setParameter('user', $user);
                },
                'empty_value' => 'Wybierz kurs'
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kni\ThomasBundle\Entity\Workshop'
        ));
    }

    public function getName()
    {
        return 'kni_thomasbundle_workshoptype';
    }
}
