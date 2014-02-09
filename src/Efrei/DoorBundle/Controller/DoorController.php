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
class DoorController extends Controller
{

    /**
     * Lists all Door entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
		
		$batiments = $em->getRepository('EfreiDoorBundle:Door')->findBatiment();
		
		foreach($batiments as $id=>$batiment) {
			$batiments[$id]["doors"] = $em->getRepository('EfreiDoorBundle:Door')->findBy(array('batiment' => $batiment["batiment"]), array('location' => 'ASC'));
		}
        $entities = $em->getRepository('EfreiDoorBundle:Door')->findAll();
        

        return $this->render('EfreiDoorBundle:Door:index.html.twig', array(
            'batiments' => $batiments,
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Door entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Door();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', array('id' => $entity->getId())));
        }

        return $this->render('EfreiDoorBundle:Door:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Door entity.
    *
    * @param Door $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Door $entity)
    {
	/*
        $form = $this->createForm(new DoorType(), $entity, array(
            'action' => $this->generateUrl('door_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
		*/
		return $this->createFormBuilder($entity)
					->setMethod('POST')
					->setAction($this->generateUrl('door_create'))
					->add('location', 'text', array(
						'required'    => true,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('batiment', 'text', array(
						'required'    => true,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('description', 'textarea', array(
						'attr' => array(
							'class' => 'form-control',
							'rows' => '3'
						),
						'required'    => true
					))
		->getForm();
			
    }

    /**
     * Displays a form to create a new Door entity.
     *
     */
    public function newAction()
    {
        $entity = new Door();
        $form   = $this->createCreateForm($entity);

        return $this->render('EfreiDoorBundle:Door:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Door entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:Door')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Door entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $accessForm = $this->createAccessForm(new Access($entity));
        
		$cardAccess = $em->getRepository('EfreiDoorBundle:Card')->AccessDoor($entity);
		
		/*
		$data_accesses = array();
		
		foreach($accesses as $access) {
			
			$letter = substr($access->getCard()->getLastname(), 1);
			$cardid = $access->getCard()->getId();
			
			$data_accesses[$letter][$cardid]["card"] = $access->getCard();
			$data_accesses[$letter][$cardid]["accesses"][] = $access;

		}
		*/
		
        return $this->render('EfreiDoorBundle:Door:show.html.twig', array(
            'entity'      => $entity,
            'card_accesses'      => $cardAccess,
            'delete_form' => $deleteForm->createView(),
            'access_form' => $accessForm->createView(),        
		));
    }
	
	public function createAccessAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		
		
        $entity = $em->getRepository('EfreiDoorBundle:Door')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Door entity.');
        }
		
		$access = new Access($entity);
		
		$accessForm = $this->createAccessForm($access);
        $accessForm->handleRequest($request);
		
		
        if ($accessForm->isValid()) {
		
			
			$em->persist($access);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', array('id' => $id)));
        } 
		
		 return $this->render('EfreiDoorBundle:Door:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $this->createDeleteForm($id)->createView(),
            'access_form' => $accessForm->createView(),        
		));
		
	}
	
    /**
     * Displays a form to edit an existing Door entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:Door')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Door entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EfreiDoorBundle:Door:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Door entity.
    *
    * @param Door $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Door $entity)
    {
		/*
        $form = $this->createForm(new DoorType(), $entity, array(
            'action' => $this->generateUrl('door_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
		*/
		
		return $this->createFormBuilder($entity)
					->setMethod('POST')
					->setAction($this->generateUrl('door_create'))
					->add('location', 'text', array(
						'required'    => true,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('batiment', 'text', array(
						'required'    => true,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('description', 'textarea', array(
						'attr' => array(
							'class' => 'form-control',
							'rows' => '3'
						),
						'required'    => true
					))
		->getForm();
    }
    /**
     * Edits an existing Door entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:Door')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Door entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', array('id' => $id)));
        }

        return $this->render('EfreiDoorBundle:Door:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Door entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EfreiDoorBundle:Door')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Door entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('door'));
    }

    /**
     * Creates a form to delete a Door entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('door_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
	
	private function createAccessForm(Access $access)
    {
        return $this->createFormBuilder($access)
			->setAction($this->generateUrl('door_create_access', array('id' => $access->getDoor()->getId())))
			->setMethod('POST')
            ->add('fromdate',    'datetime', array(
				'required' => false,
				'empty_value' => ''
			))
			->add('todate',    'datetime', array(
				'required' => false,
				'empty_value' => ''
			))
			->add('fromtime', 'time', array(
				'required' => false,
				'empty_value' => ''
			))
			->add('totime', 'time', array(
				'required' => false,
				'empty_value' => ''
			))
			->add('days', 'choice', array(
				'choices'   => array('Lundi' => 'Lundi', 'Mardi' => 'Mardi', 'Mercredi' => 'Mercredi', 'Jeudi' => 'Jeudi', 'Vendredi' => 'Vendredi', 'Samedi' => 'Samedi', 'Dimanche' => 'Dimanche'),
				'required' => false,
				'empty_value' => '',
				'multiple' => true
			))
			->add('card', 'entity', array(
				'class' => 'Efrei\DoorBundle\Entity\Card',
				'required' => true,
				'empty_value' => ''
			))
			//->add('Ajouter l\'accès', 'submit')
			->getForm()
        ;
    }
	
	
}
