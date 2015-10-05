<?php

namespace Monitor\MonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RuanganType extends AbstractType
{
	/**
	 * @var array object
	 */
	protected $em;
	
	/**
	 * @var string
	 */
	protected $asr;
	
	/**
	 * @param OrmEntityManager $em
	 * @param IdAsrama $idas
	 */
	public function __construct($em, $idas)
	{
		$this->em = $em;
		$this->asr = $idas;
	}
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$em = $this->em;
        $builder
            ->add('nama','text', array('attr' => array( 'class' => 'form-control'), 'label' => false))
            ->add('asrama', 'entity', array( 
            'class' => 'MonitorMonitorBundle:Asrama',
            'property' => 'nama',
            'empty_value' => '--Pilih Asrama--',
            'data' => $em->getReference('MonitorMonitorBundle:Asrama', $this->asr),
            'attr'=>array('class'=>'form-control'), 'required'=> false, 'label'=>false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Monitor\MonitorBundle\Entity\Ruangan'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'monitor_monitorbundle_ruangan';
    }
}
