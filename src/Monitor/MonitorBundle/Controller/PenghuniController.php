<?php

namespace Monitor\MonitorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Monitor\MonitorBundle\Entity\Penghuni;
use Monitor\MonitorBundle\Form\PenghuniType;

/**
 * Penghuni controller.
 *
 */
class PenghuniController extends Controller
{

    /**
     * Lists all Penghuni entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MonitorMonitorBundle:Penghuni')->findAll();

        return $this->render('MonitorMonitorBundle:Penghuni:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Penghuni entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Penghuni();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('penghuni_show', array('id' => $entity->getId())));
        }

        return $this->render('MonitorMonitorBundle:Penghuni:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Penghuni entity.
     *
     * @param Penghuni $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Penghuni $entity)
    {
        $form = $this->createForm(new PenghuniType(), $entity, array(
            'action' => $this->generateUrl('penghuni_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Penghuni entity.
     *
     */
    public function newAction()
    {
        $entity = new Penghuni();
        $form   = $this->createCreateForm($entity);

        return $this->render('MonitorMonitorBundle:Penghuni:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Penghuni entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Penghuni')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Penghuni entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MonitorMonitorBundle:Penghuni:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Penghuni entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Penghuni')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Penghuni entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MonitorMonitorBundle:Penghuni:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Penghuni entity.
    *
    * @param Penghuni $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Penghuni $entity)
    {
        $form = $this->createForm(new PenghuniType(), $entity, array(
            'action' => $this->generateUrl('penghuni_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Penghuni entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MonitorMonitorBundle:Penghuni')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Penghuni entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('penghuni_edit', array('id' => $id)));
        }

        return $this->render('MonitorMonitorBundle:Penghuni:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Penghuni entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MonitorMonitorBundle:Penghuni')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Penghuni entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('penghuni'));
    }

    /**
     * Creates a form to delete a Penghuni entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('penghuni_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
