<?php

namespace Monitor\MonitorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        return $this->render('MonitorMonitorBundle:Orang:index.html.twig', array(
            'entities' => $entities,
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

            return $this->redirect($this->generateUrl('orang_show', array('id' => $entity->getId())));
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
        $form = $this->createForm(new OrangType(), $entity, array(
            'action' => $this->generateUrl('orang_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

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
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MonitorMonitorBundle:Orang:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $form = $this->createForm(new OrangType(), $entity, array(
            'action' => $this->generateUrl('orang_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

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

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('orang_edit', array('id' => $id)));
        }

        return $this->render('MonitorMonitorBundle:Orang:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

            $em->remove($entity);
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
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
