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
    public function createAction(Request $request, $ru =null)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Penghuni();
        $rg = $em->getRepository('MonitorMonitorBundle:Ruangan')->find($ru);
        $form = $this->createCreateForm($entity, $ru, $rg->getAsrama()->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ruangan_show', array('id' => $rg->getId())));
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
    private function createCreateForm(Penghuni $entity, $id, $as)
    {
        $form = $this->createForm(new PenghuniType($this->getDoctrine()->getManager(), $id, $as), $entity, array(
            'action' => $this->generateUrl('penghuni_create', array('ru' => $id)),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Penghuni entity.
     *
     */
    public function newAction($id)
    {
		$em = $this->getDoctrine()->getManager();
		$ru = $em->getRepository('MonitorMonitorBundle:Ruangan')->find($id);
        $entity = new Penghuni();
        $form   = $this->createCreateForm($entity, $id, $ru->getAsrama()->getId());

        return $this->render('MonitorMonitorBundle:Penghuni:new.html.twig', array(
			'ru' => $ru,
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

        $editForm = $this->createEditForm($entity, $entity->getRuangan()->getId(), $entity->getRuangan()->getAsrama()->getId());

        return $this->render('MonitorMonitorBundle:Penghuni:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Penghuni entity.
    *
    * @param Penghuni $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Penghuni $entity, $id, $as)
    {
        $form = $this->createForm(new PenghuniType($this->getDoctrine()->getManager(), $id, $as), $entity, array(
            'action' => $this->generateUrl('penghuni_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('is_active', 'choice', array(
			'label' => false,
			'choices' => array('0' => 'Tidak Aktif', '1' => 'Aktif'),
			'data' => $entity->getIsActive(),
			'attr' => array('class' => 'form-control')
		));

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
        $ru = $entity->getRuangan()->getId();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Penghuni entity.');
        }
        $editForm = $this->createEditForm($entity, $ru, $entity->getRuangan()->getAsrama()->getId());
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ruangan_show', array('id' => $ru)));
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
            $ru = $entity->getRuangan()->getId();

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Penghuni entity.');
            }

            $entity->setIsDelete(true);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ruangan_show', array('id' => $ru)));
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
