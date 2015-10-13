<?php

namespace Monitor\MonitorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use Monitor\MonitorBundle\Entity\Orang;
use Monitor\MonitorBundle\Form\OrangType;

/**
 * Orang controller.
 *
 */
class OrangController extends Controller
{

    /**
     * Lists all Orang entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MonitorMonitorBundle:Orang')->findAll();
        
        $deleteForm = array();
        foreach ($entities as $entity) {
			$deleteForm[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
		}
		
		$paginator = $this->get('knp_paginator');
		$query = $em->getRepository('MonitorMonitorBundle:Orang')->getOrangQuery();
		$pagination = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1),
			25
		);

        return $this->render('MonitorMonitorBundle:Orang:index.html.twig', array(
            'entities' => $pagination,
            'deleteForm' => $deleteForm,
        ));
    }
    /**
     * Creates a new Orang entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Orang();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('orang'));
        }

        return $this->render('MonitorMonitorBundle:Orang:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Orang entity.
     *
     * @param Orang $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Orang $entity)
    {
        $form = $this->createForm(new OrangType($jk = null, $this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('orang_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Orang entity.
     *
     */
    public function newAction()
    {
        $entity = new Orang();
        $form   = $this->createCreateForm($entity);

        return $this->render('MonitorMonitorBundle:Orang:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Orang entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Orang')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Orang entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MonitorMonitorBundle:Orang:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Orang entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Orang')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Orang entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('MonitorMonitorBundle:Orang:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Orang entity.
    *
    * @param Orang $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Orang $entity)
    {
        $form = $this->createForm(new OrangType($entity->getJk(), $this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('orang_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Orang entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Orang')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Orang entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('orang'));
        }

        return $this->render('MonitorMonitorBundle:Orang:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Orang entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MonitorMonitorBundle:Orang')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Orang entity.');
            }

            $entity->setIsDelete(true);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('orang'));
    }

    /**
     * Creates a form to delete a Orang entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orang_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * @param j-Query request param $request
     */
    public function autocompleteAction(Request $request)
    {
		$names = array();
		$term = trim(strip_tags($request->get('term')));
		
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('MonitorMonitorBundle:Orang')->getSelectedOrang($term);
		
		foreach ($entities as $entity) {
			$names[] = $entity->getId().'-'.$entity->getNama();
		}
		
		$response = new JsonResponse();
		$response->setData($names);
		
		return $response;
	}
	
	public function ajaxAction(Request $request)
	{
		if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
		}
		
		// Get the province ID
        $id = $request->query->get('provinsi_id');
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('MonitorMonitorBundle:Kabupaten');
        $cities = $repo->findByProvince($id, array('name' => 'asc'));
        foreach ($cities as $city) {
            $result[$city->getName()] = $city->getId();
        }
        return new JsonResponse($result);
	}
}
