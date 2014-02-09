<?php

namespace Efrei\DoorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Efrei\DoorBundle\Entity\Card;
use Efrei\DoorBundle\Form\CardType;
use Efrei\DoorBundle\Entity\Access;
use Efrei\DoorBundle\Form\AccessType;


/**
 * Card controller.
 *
 */
class CardController extends Controller
{

    /**
     * Lists all Card entities.
     *
     */
    public function indexAction()
    {	
		
		$em = $this->getDoctrine()->getManager();
		
		$promotions = $em->getRepository('EfreiDoorBundle:Card')->findPromotion();
		
		foreach($promotions as $id=>$promotion) {
			$promotions[$id]["cards"] = $em->getRepository('EfreiDoorBundle:Card')->findBy(array('promotion' => $promotion["promotion"], 'type' => $promotion["type"]), array('lastname' => 'ASC', 'firstname' => 'ASC'));
		}
        
		$entities = $em->getRepository('EfreiDoorBundle:Card')->findAll();
        

        return $this->render('EfreiDoorBundle:Card:index.html.twig', array(
            'promotions' => $promotions,
            'entities' => $entities,
        ));
		
		
    }
    /**
     * Creates a new Card entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Card();
        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('card_show', array('id' => $entity->getId())));
        }

        return $this->render('EfreiDoorBundle:Card:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Card entity.
    *
    * @param Card $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Card $entity)
    {
        $form = $this->createForm(new CardType(), $entity, array(
            'action' => $this->generateUrl('card_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Card entity.
     *
     */
    public function newAction()
    {
        $entity = new Card();
        $form   = $this->createEditForm($entity);

        return $this->render('EfreiDoorBundle:Card:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Card entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:Card')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Card entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
		$accessForm = $this->createAccessForm(new Access($entity));

		$doorAccess = $em->getRepository('EfreiDoorBundle:Door')->AccessCard($entity);

        return $this->render('EfreiDoorBundle:Card:show.html.twig', array(
            'entity'      => $entity,
			'door_accesses'      => $doorAccess,

			'access_form' => $accessForm->createView(),        
            'delete_form' => $deleteForm->createView(),        ));
    }
	
	public function createAccessAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		
		
        $entity = $em->getRepository('EfreiDoorBundle:Card')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Card entity.');
        }
		
		$access = new Access($entity);
		
		$accessForm = $this->createAccessForm($access);
        $accessForm->handleRequest($request);
		
		
        if ($accessForm->isValid()) {
		
			
			$em->persist($access);
            $em->flush();

            return $this->redirect($this->generateUrl('card_show', array('id' => $id)));
        } else {
			
		}
	}

    /**
     * Displays a form to edit an existing Card entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:Card')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Card entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EfreiDoorBundle:Card:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Card entity.
    *
    * @param Card $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Card $entity)
    {	
       /*  $form = $this->createForm(new CardType(), $entity, array(
            'action' => $this->generateUrl('card_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
		*/
		return $this->createFormBuilder($entity)
					->setMethod('POST')
					->setAction($this->generateUrl('card_create'))
					->add('firstname', 'text', array(
						'required'    => true,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('lastname', 'text', array(
						'required'    => true,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('cardcode', 'text', array(
						'required'    => true,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('facilitycode', 'text', array(
						'required'    => true,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('type', 'choice', array(
						'required'    => true,
						'empty_value' => '',
						'choices' => array("Etudiant" => "Etudiant", "Administration" => "Administration", "Professeur" => "Professeur", "Autre" => "Autre"),
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('studentid', 'text', array(
						'required'    => false,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('promotion', 'choice', array(
						'empty_value' => '',
						'choices' => array("P2010" => "P2010", "P2011" => "P2011", "P2012" => "P2012", "P2013" => "P2013", "P2014" => "P2014", "P2015" => "P2015", "P2016" => "P2016", "P2017" => "P2017", "P2018" => "P2018", "P2019" => "P2019", "P2020" => "P2020", "P2021" => "P2021"),
						'required'    => false,
						'attr' => array(
							'class' => 'form-control',
						),
					))
					->add('description', 'textarea', array(
						'attr' => array(
							'class' => 'form-control',
							'rows' => '3'
						),
						'required'    => false
					))
		->getForm();
    }
    /**
     * Edits an existing Card entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:Card')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Card entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('card_show', array('id' => $id)));
        }

        return $this->render('EfreiDoorBundle:Card:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Card entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EfreiDoorBundle:Card')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Card entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('card'));
    }

    /**
     * Creates a form to delete a Card entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('card_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
	
	private function createAccessForm(Access $access)
    {
        return $this->createFormBuilder($access)
			->setAction($this->generateUrl('card_create_access', array('id' => $access->getCard()->getId())))
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
			->add('door', 'entity', array(
				'class' => 'Efrei\DoorBundle\Entity\Door',
				'required' => true,
				'empty_value' => ''
			))
			//->add('Ajouter l\'accès', 'submit')
			->getForm()
		;
    }
}
