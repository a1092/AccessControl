<?php

namespace Efrei\DoorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Efrei\DoorBundle\Entity\Door;
use Efrei\DoorBundle\Form\DoorType;

use Efrei\DoorBundle\Entity\Access;
use Efrei\DoorBundle\Form\AccessType;

/**
 * Door controller.
 *
 */
class HomeController extends Controller
{

    /**
     * Lists all Door entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
		
		/*
		$batiments = $em->getRepository('EfreiDoorBundle:Door')->findBatiment();
		
		foreach($batiments as $id=>$batiment) {
			$batiments[$id]["doors"] = $em->getRepository('EfreiDoorBundle:Door')->findBy(array('batiment' => $batiment["batiment"]), array('location' => 'ASC'));
		}
        $entities = $em->getRepository('EfreiDoorBundle:Door')->findAll();
        */

        return $this->render('EfreiDoorBundle::index.html.twig', array(
            //'batiments' => $batiments,
            //'entities' => $entities,
        ));
    }
}
