<?php

namespace Monitor\MonitorBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class EditUserPasswordType extends AbstractType
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
			->add('plainPassword', 'repeated', array(
				'type' => 'password',
				'first_options' => array(
					'label' => 'Password Baru',
					'attr' => array('class' => 'form-control'),
				),
				'second_options' => array(
					'label' => 'Ulangi Password Baru',
					'attr' => array('class' => 'form-control')
				),
				'invalid_message' => 'Password yang diulangi tidak cocok',
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
     * @return string
     */
    public function getName()
    {
        return 'monitor_monitorbundle_edituserpassword';
    }
}
