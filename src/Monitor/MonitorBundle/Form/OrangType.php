<?php

namespace Monitor\MonitorBundle\Form;

use Doctrine\ORM\EntityManager;
use Monitor\MonitorBundle\Entity\Provinsi;
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
        
        // Add listeners
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }
    
     protected function addElements(FormInterface $form, Provinsi $provinsi = null) {
        // Add the province element
        $form->add('provinsi', 'entity', array(
			'attr'=>array('class'=>'form-control', 'placeholder'=>'Provinsi Anda'),
            'data' => $provinsi,
            'required'=> false,
            'empty_value' => '-- Pilih Provinsi --',
            'class' => 'MonitorMonitorBundle:Provinsi',
            'mapped' => false)
        );

        // Cities are empty, unless we actually supplied a province
        $cities = array();
        if ($provinsi) {
            // Fetch the cities from specified province
            $repo = $this->em->getRepository('MonitorMonitorBundle:Kabupaten');
            $cities = $repo->findByProvinsi($provinsi, array('name' => 'asc'));
        }

        // Add the city element
        $form->add('kabupaten', 'entity', array(
			'attr'=>array('class'=>'form-control', 'placeholder'=>'Kota/Kabupaten Anda'),
			'required'=> false,
            'empty_value' => '-- Pilih provinsi dulu --',
            'class' => 'MonitorMonitorBundle:Kabupaten',
            'choices' => $cities,
        ));
    }
    
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // Note that the data is not yet hydrated into the entity.
        $province = $this->em->getRepository('MonitorMonitorBundle:Provinsi')->find($data['provinsi']);
        $this->addElements($form, $provinsi);
    }
    
    function onPreSetData(FormEvent $event) {
        $account = $event->getData();
        $form = $event->getForm();

        // We might have an empty account (when we insert a new account, for instance)
        $provinsi = $account->getKabupaten() ? $account->getKabupaten()->getProvinsi() : null;
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
