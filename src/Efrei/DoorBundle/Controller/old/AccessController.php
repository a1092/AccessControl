<?php

namespace Efrei\DoorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccessController extends Controller
{
    public function disableAction($id, $from)
    {
		$em = $this->getDoctrine()->getManager();
		
		$access = $em->getRepository('EfreiDoorBundle:Access')
					 ->find($id);
		
		if($access === null)
		{
			throw $this->createNotFoundException('Access[id='.$id.'] inexistant.');
		}
		
		$access->setActive(0);
		
		$em->persist($access);
		$em->flush();
		
		
		if($from == 'door') {
			return $this->redirect($this->generateUrl('efrei_door_view_door', array('id' => $access->getDoor()->getId())));
		}
        return null;
    }
}
