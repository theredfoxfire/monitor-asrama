<?php

namespace Monitor\MonitorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Monitor\MonitorBundle\Entity\Asrama;
use Monitor\MonitorBundle\Entity\Ruangan;
use Monitor\MonitorBundle\Form\RuanganType;
use Monitor\MonitorBundle\Form\AsramaType;

/**
 * Asrama controller.
 *
 */
class AsramaController extends Controller
{

    /**
     * Lists all Asrama entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = array();
        $entities = $em->getRepository('MonitorMonitorBundle:Asrama')->findAll();
        foreach ($entities as $entity) {
			$deleteForm[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
		}
		
		$paginator = $this->get('knp_paginator');
		$query = $em->getRepository('MonitorMonitorBundle:Asrama')->getAsrama();
        $pagination = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1),
			25
		);

        return $this->render('MonitorMonitorBundle:Asrama:index.html.twig', array(
            'entities' => $pagination,
            'deleteForm' => $deleteForm,
        ));
    }
    /**
     * Creates a new Asrama entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Asrama();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('asrama'));
        }

        return $this->render('MonitorMonitorBundle:Asrama:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Asrama entity.
     *
     * @param Asrama $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Asrama $entity)
    {
		$form = $this->createForm(new AsramaType(), $entity, array(
            'action' => $this->generateUrl('asrama_create'),
            'method' => 'POST',
        ));  
        return $form;
    }

    /**
     * Displays a form to create a new Asrama entity.
     *
     */
    public function newAction()
    {
        $entity = new Asrama();
        $form   = $this->createCreateForm($entity);

        return $this->render('MonitorMonitorBundle:Asrama:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Asrama entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entityAs = $em->getRepository('MonitorMonitorBundle:Asrama')->find($id);
        
        if (!$entityAs) {
			throw $this->createNotFoundException('Data asrama tidak ditemukan');
		}

        $entities = $em->getRepository('MonitorMonitorBundle:Ruangan')->getRuangan($id);
        
        $deleteForm = array();
        foreach ($entities as $entity) {
			$deleteForm[$entity->getId()] = $this->createDeleteRuanganForm($entity->getId())->createView();
		}
        
        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('MonitorMonitorBundle:Ruangan')->getRuanganQuery($id);
        $pagination = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1),
			25
		);

        return $this->render('MonitorMonitorBundle:Asrama:show.html.twig', array(
            'entities' => $pagination,
            'entityAs' => $entityAs,
            'deleteForm' => $deleteForm,
        ));
    }

    /**
     * Displays a form to edit an existing Asrama entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Asrama')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Asrama entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('MonitorMonitorBundle:Asrama:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Asrama entity.
    *
    * @param Asrama $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Asrama $entity)
    {
        $form = $this->createForm(new AsramaType(), $entity, array(
            'action' => $this->generateUrl('asrama_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        
        $form->add('is_active', 'choice', array('choices'=> array('0' => 'Ditutup', '1' => 'Aktif'), 'data' => $entity->getIsActive(),
			'attr'=>array('class'=>'form-control', 'required'=> false), 'label'=>false));

        return $form;
    }
    /**
     * Edits an existing Asrama entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Asrama')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Asrama entity.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('asrama'));
        }

        return $this->render('MonitorMonitorBundle:Asrama:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Asrama entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MonitorMonitorBundle:Asrama')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Asrama entity.');
            }

            $entity->setIsDelete(true);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('asrama'));
    }

    /**
     * Creates a form to delete a Asrama entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('asrama_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Creates a form to delete a Ruangan entity by id
     * 
     * @param mixed $id The entity id
     * 
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteRuanganForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ruangan_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
