<?php

namespace Monitor\MonitorBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserType extends AbstractType
{
	/**
	 * @var object
	 */
    protected $em;
    /**
     * @var integer
     */
    protected $acc;
    
    /**
     * @var string
     */
    protected $as;
    
    /**
     * @param DoctrineEntityManager $em
     */
    public function __construct(EntityManager $entityManager = null, $acc = null, $as = null)
    {
		$this->em = $entityManager;
		$this->acc = $acc;
		$this->as = $as;
	}
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$eR = $this->em->getRepository('MonitorMonitorBundle:Asrama');
        $builder
			->add('username', 'text', array(
				'attr' => array('class' => 'form-control'),
				'label' => false,
			))
			->add('email', 'text', array(
				'attr' => array('class' => 'form-control'),
				'label' => false
			))
            ->add('plainPassword', 'repeated', array(
				'type' => 'password',
				'first_options' => array(
					'label' => 'Password',
					'attr' => array('class' => 'form-control'),
				),
				'second_options' => array(
					'label' => 'Ulangi Password',
					'attr' => array('class' => 'form-control')
				),
				'invalid_message' => 'Password yang diulangi tidak cocok',
            ))
            ->add('asrama', 'entity', array(
				'class' => 'MonitorMonitorBundle:Asrama',
				'query_builder' => function ($er) use ($eR) {
						return $er->createQueryBuilder('a')
						->where('a.is_delete = :del and a.is_active = :is')
						->setParameters(array('del' => false, 'is' => true ));
					},
				'property' => 'nama',
				'empty_value' => '--Pilih Akses Asrama--',
				'attr' => array('class' => 'form-control'),
				'label' => false,
				'data' => $this->as,
				'required' => false
            ))
            ->add('roles', 'choice', array(
				'attr' => array('class' => 'form-control'),
				'empty_value' => '--Pilih Hak Akses--',
				'choices' => array('ROLE_SUPER_ADMIN' => 'Super Admin', 'ROLE_ADMIN' => 'Admin Asrama'),
				'data' => $this->acc,
				'label' => false,
				'multiple' => true
			))
			
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Monitor\MonitorBundle\Entity\User'
        ));
    }
    
    /**
     * @return fosuser registration
     */
    public function getParent()
    {
		return 'fos_user_registration';
	}

    /**
     * @return string
     */
    public function getName()
    {
        return 'monitor_monitorbundle_user';
    }
}
