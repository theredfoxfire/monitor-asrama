<?php

namespace Monitor\MonitorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$name = "";
        return $this->render('MonitorMonitorBundle:Default:greeting.html.twig', array('name' => $name));
    }
}
