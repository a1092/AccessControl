<?php

namespace Efrei\DoorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Efrei\DoorBundle\Entity\Card;

use Efrei\DoorBundle\Entity\Access;
use Efrei\DoorBundle\Form\AccessType;

class CardController extends Controller
{
    public function indexAction()
    {
		$cards = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('EfreiDoorBundle:Card')
						 ->findAll();
						 
        return $this->render('EfreiDoorBundle:Card:list.html.twig', array(
			'cards' => $cards
		));
    }
	
	public function viewAction($id) {
		
		$card = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('EfreiDoorBundle:Card')
						 ->find($id);
						 
		if($card === null)
		{
			throw $this->createNotFoundException('Card[id='.$id.'] inexistant.');
		}
		
		/* Formulaire d'ajout des droits d'accès */
	
		$access = new Access;
		$form = $this->createForm(new AccessType, $access);
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			
			$form->bind($request);
			
			$access->setDoor($door);
			
			if ($form->isValid()) {
				
				$em = $this->getDoctrine()->getManager();
				$em->persist($access);
				$em->flush();
			} else {
				throw $this->createNotFoundException('Access form invalid.');
			}
		}
		
		$accesses_active = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('EfreiDoorBundle:Access')
						 ->findActiveByCard($card);

		return $this->render('EfreiDoorBundle:Card:view.html.twig', array(
			'card' => $card,
			'accesses_active' => $accesses_active,
			'form' => $this->createForm(new AccessType, new Access($card))->createView()

		));
	}
	
	
	public function editAction($id = null) {
	
		if(empty($id))
			$card = new Card();
		else {
			$card = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('EfreiDoorBundle:Card')
						 ->find($id);
		}
		
		
		$form = $this->createFormBuilder($card)
				->add('firstname',    'text')
				->add('lastname',    'text')
				->add('cardcode', 'integer')
				->add('facilitycode', 'integer')
				->add('description', 'textarea')
				->getForm();

		
		$request = $this->get('request');

		if ($request->getMethod() == 'POST') {
		 
			$form->bind($request);

	
			if ($form->isValid()) {
			
				$em = $this->getDoctrine()->getManager();
				$em->persist($card);
				$em->flush();

				
				return $this->redirect($this->generateUrl('efrei_door_list_card', array()));
			}
		}
		
		return $this->render('EfreiDoorBundle:Card:new.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
