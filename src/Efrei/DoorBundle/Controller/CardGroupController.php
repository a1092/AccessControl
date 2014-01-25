<?php

namespace Efrei\DoorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Efrei\DoorBundle\Entity\CardGroup;
use Efrei\DoorBundle\Form\CardGroupType;

use Efrei\DoorBundle\Entity\Access;
use Efrei\DoorBundle\Form\AccessType;


/**
 * CardGroup controller.
 *
 */
class CardGroupController extends Controller
{

    /**
     * Lists all CardGroup entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EfreiDoorBundle:CardGroup')->findAll();

        return $this->render('EfreiDoorBundle:CardGroup:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CardGroup entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CardGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('group_show', array('id' => $entity->getId())));
        }

        return $this->render('EfreiDoorBundle:CardGroup:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a CardGroup entity.
    *
    * @param CardGroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(CardGroup $entity)
    {
        $form = $this->createForm(new CardGroupType(), $entity, array(
            'action' => $this->generateUrl('group_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CardGroup entity.
     *
     */
    public function newAction()
    {
        $entity = new CardGroup();
        $form   = $this->createCreateForm($entity);

        return $this->render('EfreiDoorBundle:CardGroup:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CardGroup entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:CardGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CardGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
		$accessForm = $this->createAccessForm(new Access($entity));
		
        return $this->render('EfreiDoorBundle:CardGroup:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'access_form' => $accessForm->createView(),        
		));
    }
	
	public function createAccessAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		
		
        $entity = $em->getRepository('EfreiDoorBundle:CardGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Door entity.');
        }
		
		$access = new Access($entity);
		$access->setDoor($entity->getDoor());
		
		$accessForm = $this->createAccessForm($access);
        $accessForm->handleRequest($request);
		
		
        if ($accessForm->isValid()) {
		
			
			$em->persist($access);
            $em->flush();

            return $this->redirect($this->generateUrl('group_show', array('id' => $id)));
        } else {
			
		}
	}
	
	public function deleteAccessAction($id)
    {
        
        
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('EfreiDoorBundle:Access')->find($id);
		
		
		
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Access entity.');
		}
		
		$entity->setActive(0);
		
		
		$em->flush();
        

        return $this->redirect($this->generateUrl('group_show', array('id' => $entity->getGroup()->getId())));
    }

    /**
     * Displays a form to edit an existing CardGroup entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:CardGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CardGroup entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EfreiDoorBundle:CardGroup:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CardGroup entity.
    *
    * @param CardGroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CardGroup $entity)
    {
        $form = $this->createForm(new CardGroupType(), $entity, array(
            'action' => $this->generateUrl('group_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CardGroup entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:CardGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CardGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('group_show', array('id' => $id)));
        }

        return $this->render('EfreiDoorBundle:CardGroup:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CardGroup entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EfreiDoorBundle:CardGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CardGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('group'));
    }

    /**
     * Creates a form to delete a CardGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('group_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
	
	private function createAccessForm(Access $access)
    {
        return $this->createFormBuilder($access)
			->setAction($this->generateUrl('group_create_access', array('id' => $access->getGroup()->getId())))
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
			->add('card', 'entity', array(
				'class' => 'Efrei\DoorBundle\Entity\Card',
				'required' => true,
				'empty_value' => ''
			))
			->add('submit', 'submit')
			->getForm()
        ;
    }
}
