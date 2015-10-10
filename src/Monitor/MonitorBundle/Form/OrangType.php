<?php

namespace Monitor\MonitorBundle\Form;

use Doctrine\ORM\EntityManager;
use Lc\LcBundle\Entity\Provinsi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class OrangType extends AbstractType
{
	/**
	 * @var string
	 */
	protected $jk;
	
	/**
	 * @var object 
	 */
	protected $em;
	 /**
	  * @param String OrangJk $jk
	  * @param Object DoctrineEntityManager $em
	  */
	public function __construct($jk = null, EntityManager $em = null)
	{
		$this->jk = $jk;
		$this->em = $em;
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
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }
    
    /**
     * @param FromInterface $form
     * @param EntityProvinsi $provinsi
     */
    protected function addElements(FormInterface $form, Provinsi $provinsi = null)
    {
		$form->add('provinsi', 'entity', array(
				'attr' => array('class' => 'form-control'),
				'data' => $provinsi,
				'empty_value' => '--Pilih Asal Provinsi--',
				'class' => 'MonitorMonitorBundle:Provinsi',
				'mapped' => false,
				'label' => false
			)
		);
		
		$kabupaten = array();
		if ($provinsi) {
			
			$repo = $this->em->getRepository('MonitorMonitorBundle:Kabupaten');
			$kabupaten = $repo->findByProvinsi($provinsi, array('name' => 'asc'));
		}
		
		$form->add('kabupaten', 'entity', array(
				'attr' => array('class' => 'form-control'),
				'empty_value' => '--Pilih Provinsi Dulu--',
				'class' => 'MonitorMonitorBundle:Kabupaten',
				'choices' => $kabupaten,
				'label' => false
			)
		);
	}
    
    /**
     * @param FormEvent $event
     */
    protected function onPreSubmit(FormEvent $event)
    {
		$form = $event->getForm();
		$data = $evetn->getData();
		
		$provinsi = $this->em->getRepository('MonitorMonitorBundle:Provinsi')->find($data['provinsi']);
		$this->addElements($form, $provinsi);
	}
    
    /**
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event)
    {
		$form = $event->getForm();
		$kabupaten = $event->getData();
		
		$provinsi = $kabupaten->getKabupaten() ? $kabupaten->getKabupaten->getProvinsi() : null;
		$this->addElements($form, $provinsi);
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
