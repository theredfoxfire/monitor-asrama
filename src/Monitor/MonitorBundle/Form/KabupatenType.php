<?php

namespace Monitor\MonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KabupatenType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('is_delete')
            ->add('is_active')
            ->add('created_at')
            ->add('updated_at')
            ->add('token')
            ->add('provinsi')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Monitor\MonitorBundle\Entity\Kabupaten'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'monitor_monitorbundle_kabupaten';
    }
}
