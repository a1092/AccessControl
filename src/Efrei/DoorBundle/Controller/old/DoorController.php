<?php

namespace Efrei\DoorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Efrei\DoorBundle\Entity\Door;


use Efrei\DoorBundle\Entity\Access;
use Efrei\DoorBundle\Form\AccessType;

class DoorController extends Controller
{
    public function indexAction()
    {
		$doors = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('EfreiDoorBundle:Door')
						 ->findAll();
						 
        return $this->render('EfreiDoorBundle:Door:list.html.twig', array(
			'doors' => $doors
		));
    }
	
	public function viewAction($id) {
		
		$door = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('EfreiDoorBundle:Door')
						 ->find($id);
						 
		if($door === null)
		{
			throw $this->createNotFoundException('Door[id='.$id.'] inexistant.');
		}
		
		
		/* Formulaire d'ajout des droits d'accès */
	
		$access = new Access;
		$access->setDoor($door);
		
		$form = $this->createForm(new AccessType, $access);
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			
			$form->bind($request);
			
			
			
			if ($form->isValid()) {
				
				
				$em = $this->getDoctrine()->getManager();
				$em->persist($access);
				$em->flush();
			} else {
				
				throw $this->createNotFoundException();
			}
		}
		
		$accesses_active = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('EfreiDoorBundle:Access')
						 ->findActiveByDoor($door);

		
		return $this->render('EfreiDoorBundle:Door:view.html.twig', array(
			'door' => $door,
			'accesses_active' => $accesses_active,
			'form' => $this->createForm(new AccessType, new Access($door))->createView()
		));
	}
	
	
	public function editAction($id = null) {
	
		if(empty($id))
			$door = new Door();
		else {
			$door = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('EfreiDoorBundle:Door')
						 ->find($id);
		}
		
		
		$form = $this->createFormBuilder($door)
				->add('location',    'text')
				->add('batiment',    'text')
				->add('description', 'textarea')
				->getForm();

		
		$request = $this->get('request');

		if ($request->getMethod() == 'POST') {
		 
			$form->bind($request);

	
			if ($form->isValid()) {
			
				$em = $this->getDoctrine()->getManager();
				$em->persist($door);
				$em->flush();

				
				return $this->redirect($this->generateUrl('efrei_door_list_door', array()));
			}
		}
		
		return $this->render('EfreiDoorBundle:Door:new.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
