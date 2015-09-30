<?php

namespace Monitor\MonitorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Monitor\MonitorBundle\Entity\Asrama;
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

        $entities = $em->getRepository('MonitorMonitorBundle:Asrama')->findAll();

        return $this->render('MonitorMonitorBundle:Asrama:index.html.twig', array(
            'entities' => $entities,
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

            return $this->redirect($this->generateUrl('asrama_show', array('id' => $entity->getId())));
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

        $entity = $em->getRepository('MonitorMonitorBundle:Asrama')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Asrama entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MonitorMonitorBundle:Asrama:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
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
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MonitorMonitorBundle:Asrama:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        $form->add('submit', 'submit', array('label' => 'Update'));

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

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('asrama_edit', array('id' => $id)));
        }

        return $this->render('MonitorMonitorBundle:Asrama:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

            $em->remove($entity);
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
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
