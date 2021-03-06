<?php
namespace Monitor\MonitorBundle\Form;
use Doctrine\ORM\EntityManager;
use Monitor\MonitorBundle\Entity\Provinsi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class ReportType extends AbstractType
{
        /**
     * @var object 
     */
    protected $em;
    public function __construct(EntityManager $em = null)
    {
        $this->em = $em;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $angkatan = array();
        for ($t = 2010; $t <= date('Y'); $t++) {
            $angkatan[$t] = $t;
        }
        $eR = $this->em->getRepository('MonitorMonitorBundle:Asrama');
        $builder
            ->add('tanggal_1','date', array(
                'label' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control date',
                    'placeholder' => 'Batas Awal (Biarkan Kosong untuk Melihat semua Tanggal)'
                )
            ))
            ->add('tanggal_2','date', array(
                'label' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control date2',
                    'placeholder' => 'Batas Akhir'
                )
            ))
            ->add('asrama', 'entity', array(
                'class' => 'MonitorMonitorBundle:Asrama',
                'query_builder' => function($er) use ($eR) {
                    return $er->createQueryBuilder('r')
                        ->where('r.is_active = :is and r.is_delete = :del')
                        ->setParameters(array('is' => 1, 'del' => false));
                },
                'property' => 'nama',
                'attr' => array('class' => 'form-control'),
                'required' => false,
                'label' => false,
                'empty_value' => '--Tampilkan Semua Asrama--'
            ))
            ->add('jk', 'choice', array(
				'choices' => array('Perempuan' => 'Perempuan', 'Laki-laki' => 'Laki-laki'),
				'label' => false,
                'required' => false,
				'empty_value' => '--Tampilkan Semua Jenis Kelamin--',
				'attr' => array('class' => 'form-control'),
            ))
            ->add('angkatan', 'choice', array(
                'choices' => $angkatan,
                'label' => false,
                'required' => false,
                'empty_value' => '--Tampilkan Semua Angkatan--',
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
            'empty_value' => '-- Pilih Provinsi (Biarkan kosong untuk melihat semua Kabupaten) --',
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
            'empty_value' => '-- Pilih Provinsi Terlebih Dahulu --',
            'class' => 'MonitorMonitorBundle:Kabupaten',
            'choices' => $cities,
        ));
    }
    
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        // Note that the data is not yet hydrated into the entity.
        $provinsi = $this->em->getRepository('MonitorMonitorBundle:Provinsi')->find($data['provinsi']);
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
            'data_class' => 'Monitor\MonitorBundle\Entity\Report'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'monitor_monitorbundle_report';
    }
}
