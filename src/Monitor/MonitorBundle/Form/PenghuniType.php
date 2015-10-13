<?php

namespace Monitor\MonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PenghuniType extends AbstractType
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
	 * @var string
	 */
	protected $ru;
	
	/**
	 * @var boolean
	 */
	protected $edit;
	
	/**
	 * @param OrmEntityManager $em
	 * @param IdRuangan $ru
	 * @param IdAsrama $asr
	 */
	public function __construct($em = null, $ru = null, $asr = null, $edit = null)
	{
		$this->em = $em;
		$this->ru = $ru;
		$this->asr = $asr;
		$this->edit = $edit;
	}
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$em = $this->em;
		$eR = $em->getRepository('MonitorMonitorBundle:Ruangan');
        $builder
            ->add('tanggal','date', array(
				'label' => false,
				'widget' => 'single_text',
				'format' => 'dd-MM-yyyy',
				'attr' => array(
					'class' => 'form-control date',
				)
			))
            ->add('ruangan', 'entity', array(
				'class' => 'MonitorMonitorBundle:Ruangan',
				'query_builder' => function($er) use ($eR) {
					return $er->createQueryBuilder('r')
						->where('r.id = :asr and r.is_active = :is and r.is_delete = :del')
						->setParameters(array('asr' => $this->ru, 'is' => 1, 'del' => false));
				},
				'property' => 'nama',
				'attr' => array('class' => 'form-control'),
				'required' => true,
				'label' => false
            ));
            if ($this->edit == true) {
				$builder->add('orang', 'entity', array(
					'class' => 'MonitorMonitorBundle:Orang',
					'property' => 'nama',
					'empty_value' => '--Pilih Orang--',
					'attr' => array('class' => 'form-control', 'disabled' => true),
					'required' => true,
					'label' => false
				));
			} else {
				$builder->add('orang', 'text', array(
					
					'attr' => array('class' => 'form-control'),
					'required' => true,
					'label' => false
				));
			}
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Monitor\MonitorBundle\Entity\Penghuni'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'monitor_monitorbundle_penghuni';
    }
}
