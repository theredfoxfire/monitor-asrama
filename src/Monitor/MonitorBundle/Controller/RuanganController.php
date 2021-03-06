<?php

namespace Monitor\MonitorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Monitor\MonitorBundle\Entity\Ruangan;
use Monitor\MonitorBundle\Form\RuanganType;

/**
 * Ruangan controller.
 *
 */
class RuanganController extends Controller
{

    /**
     * Lists all Ruangan entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MonitorMonitorBundle:Ruangan')->findAll();

        return $this->render('MonitorMonitorBundle:Ruangan:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Ruangan entity.
     *
     */
    public function createAction(Request $request, $idas)
    {
		$em = $this->getDoctrine()->getManager();
        $entity = new Ruangan();
        $form = $this->createCreateForm($entity, $idas);
        $form->handleRequest($request);
        $as = $em->getRepository('MonitorMonitorBundle:Asrama')->find($idas);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('asrama_show', array('id' => $idas)));
        }

        return $this->render('MonitorMonitorBundle:Ruangan:new.html.twig', array(
            'entity' => $entity,
            'as' => $as,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Ruangan entity.
     *
     * @param Ruangan $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ruangan $entity, $idas)
    {
        $form = $this->createForm(new RuanganType($this->getDoctrine()->getManager(), $idas), $entity, array(
            'action' => $this->generateUrl('ruangan_create', array('idas' => $idas)),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Ruangan entity.
     *
     */
    public function newAction($idas = null)
    {
		$em = $this->getDoctrine()->getManager();
        $entity = new Ruangan();
        $form   = $this->createCreateForm($entity, $idas);
        
        $as = $em->getRepository('MonitorMonitorBundle:Asrama')->find($idas);

        return $this->render('MonitorMonitorBundle:Ruangan:new.html.twig', array(
            'entity' => $entity,
            'as' => $as,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ruangan entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entityRu = $em->getRepository('MonitorMonitorBundle:Ruangan')->find($id);
        $entities = $em->getRepository('MonitorMonitorBundle:Penghuni')->getPenghuni($id);
        $query = $em->getRepository('MonitorMonitorBundle:Penghuni')->getPenghuniQuery($id);

        if (!$entityRu) {
            throw $this->createNotFoundException('Unable to find Ruangan entity.');
        }

        $deleteForm = array();
        foreach ($entities as $entity) {
			$deleteForm[$entity->getId()] = $this->createDeletePenghuniForm($entity->getId())->createView();
		}
		
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1),
			25
		);

        return $this->render('MonitorMonitorBundle:Ruangan:show.html.twig', array(
			'entities' => $pagination,
            'entityRu'      => $entityRu,
            'deleteForm' => $deleteForm,
        ));
    }

    /**
     * Displays a form to edit an existing Ruangan entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Ruangan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ruangan entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('MonitorMonitorBundle:Ruangan:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Ruangan entity.
    *
    * @param Ruangan $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ruangan $entity)
    {
        $form = $this->createForm(new RuanganType($this->getDoctrine()->getManager(), $entity->getAsrama()->getId()), $entity, array(
            'action' => $this->generateUrl('ruangan_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('is_active', 'choice', array('label' => false, 'choices' => array('0' => 'Ditutup', '1' =>'Aktif'), 
        'attr' => array('class' =>'form-control'), 'data' => $entity->getIsActive()));

        return $form;
    }
    /**
     * Edits an existing Ruangan entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Ruangan')->find($id);
        $as = $entity->getAsrama()->getId();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ruangan entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('asrama_show', array('id' => $as)));
        }

        return $this->render('MonitorMonitorBundle:Ruangan:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Ruangan entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MonitorMonitorBundle:Ruangan')->find($id);
            $asr = $entity->getAsrama()->getId();

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ruangan entity.');
            }

            $entity->setIsDelete(true);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('asrama_show', array('id' => $asr)));
    }

    /**
     * Creates a form to delete a Ruangan entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ruangan_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    private function createDeletePenghuniForm($id)
    {
		return $this->createFormBuilder()
			->setAction($this->generateUrl('penghuni_delete', array('id' => $id)))
			->setMethod('DELETE')
			->getForm()
			;
	}
}
