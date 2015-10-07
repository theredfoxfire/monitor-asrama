<?php

namespace Monitor\MonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrangType extends AbstractType
{
	/**
	 * @var string
	 */
	 protected $jk;
	 
	 /**
	  * @param String OrangJk $jk
	  */
	public function __construct($jk = null)
	{
		$this->jk = $jk;
	}
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nama', 'text', array(
				'label' => false,
				'attr' => array('class' => 'form-control'),
			))
            ->add('no_identitas', 'text', array(
				'label' => false,
				'attr' => array('class' => 'form-control'),
            ))
            ->add('jk', 'choice', array(
				'choices' => array('Perempuan' => 'Perempuan', 'Laki-laki' => 'Laki-laki'),
				'label' => false,
				'empty_value' => '--Pilih Jenis Kelamin--',
				'attr' => array('class' => 'form-control'),
				'data' => $this->jk
            ))
            ->add('alamat', 'textarea', array(
				'label' => false,
				'attr' => array('class' => 'form-control'),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Monitor\MonitorBundle\Entity\Orang'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'monitor_monitorbundle_orang';
    }
}
