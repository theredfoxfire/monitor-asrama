<?php

namespace Monitor\MonitorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Monitor\MonitorBundle\Entity\Penghuni;
use Monitor\MonitorBundle\Form\PenghuniType;
use Monitor\MonitorBundle\Entity\Report;
use Monitor\MonitorBundle\Form\ReportType;

use ExcelAnt\Adapter\PhpExcel\Workbook\Workbook,
    ExcelAnt\Adapter\PhpExcel\Sheet\Sheet,
    ExcelAnt\Adapter\PhpExcel\Writer\Writer,
    ExcelAnt\Table\Table,
    ExcelAnt\Coordinate\Coordinate,
    ExcelAnt\Adapter\PhpExcel\Writer\WriterFactory,
    ExcelAnt\Adapter\PhpExcel\Writer\PhpExcelWriter\Excel5;
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
        $entity = new Penghuni($em);
        $rg = $em->getRepository('MonitorMonitorBundle:Ruangan')->find($ru);
        $form = $this->createCreateForm($entity, $ru, $rg->getAsrama()->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
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
        $entity = new Penghuni($em);
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
        $form = $this->createForm(new PenghuniType($this->getDoctrine()->getManager(), $id, $as, $edit=true), $entity, array(
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
            'form'   => $editForm->createView(),
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

    public function reportAction()
    {
        $report = new Report();
        $form = $this->createForm(new ReportType($this->getDoctrine()->getManager()),$report, array(
            'action' => $this->generateUrl('penghuni_show_report'),
            'method' => 'POST',
            'attr' => array('target' => '_blank'),
        ));

        $form = $form->createView();

        return $this->render('MonitorMonitorBundle:Penghuni:report.html.twig', array(
            'entity' => $report,
            'form' => $form,
        ));
    }

    public function showReportAction(Request $request)
    {
        $formData = $request->get('monitor_monitorbundle_report');
        $tgl1 = new \DateTime($formData['tanggal_1']);
        $tgl2 = new \DateTime($formData['tanggal_2']);
        
        if ($tgl2 < $tgl1) {
            $tgl1 = $tgl2;
            $tgl2 = $tgl1;
        }

        if (($formData['tanggal_1'] == null) or ($formData['tanggal_2'] == null)) {
            $tgl1 = null ;
            $tgl2 = null ; 
        }

        $data = array(
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kabupaten' => $formData['kabupaten'],
            'asrama' => $formData['asrama'],
            'angkatan' => $formData['angkatan'],
            'jk' => $formData['jk'],
        );

        $query = $this->getDoctrine()->getManager()->getRepository('MonitorMonitorBundle:Penghuni')->getReportQuery($data);

        $paginator = $this->get('knp_paginator');
        $report = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            25
        );

        return  $this->render('MonitorMonitorBundle:Penghuni:showReport.html.twig',
                array(
                    'data' => $data,
                    'entities' => $report,
                )
            );
    }

    public function excelAction($data)
    {
        $data = json_decode($data);
        $penghuni = $this->getDoctrine()->getManager()->getRepository('MonitorMonitorBundle:Penghuni')->getReportData($data);
        $workbook = new Workbook();
        $sheet = new Sheet($workbook);
        $table = new Table();

        foreach ($penghuni as $p) {
            $table->setRow([
                    $p->getTanggal(),
                    $p->getOrang()->getNoIdentitas(),
                    $p->getOrang()->getJk(),
                    $p->getRuangan()->getAsrama()->getNama(),
                    $p->getOrang()->getKabupaten()->getProvinsi()->getName().' - '.$p->getOrang()->getKabupaten()->getName(),
            ]);
        }

        $sheet->addTable($table, new Coordinate(1,1));
        $workbook->addSheet($sheet);
        $d = date('Y-m-d-H-i-s');

        $writer = (new WriterFactory())->createWriter(new Excel5(__DIR__.'/../../../../web/export/excel/'.$d.'-data-asrama.xls'));
        $phpExcel = $writer->convert($workbook);
        $writer->write($phpExcel);
        
        $filePath = __DIR__.'/../../../../web/export/excel/'.$d.'-data-asrama.xls';

        $fs = new FileSystem();
        if (!$fs->exists($filePath)) {
            throw $this->createNotFoundException();
        }

        // prepare BinaryFileResponse
        $filename = $d.'-data-penghuni-asrama.xls';
        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();

        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;
    }
}
