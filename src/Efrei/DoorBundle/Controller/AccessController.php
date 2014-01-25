<?php

namespace Efrei\DoorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Efrei\DoorBundle\Entity\Access;
use Efrei\DoorBundle\Form\AccessType;

/**
 * Access controller.
 *
 */
class AccessController extends Controller
{

    /**
     * Lists all Access entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EfreiDoorBundle:Access')->findAll();

        return $this->render('EfreiDoorBundle:Access:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Access entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Access();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('access_show', array('id' => $entity->getId())));
        }

        return $this->render('EfreiDoorBundle:Access:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Access entity.
    *
    * @param Access $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Access $entity)
    {
        $form = $this->createForm(new AccessType(), $entity, array(
            'action' => $this->generateUrl('access_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Access entity.
     *
     */
    public function newAction()
    {
        $entity = new Access();
        $form   = $this->createCreateForm($entity);

        return $this->render('EfreiDoorBundle:Access:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Access entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:Access')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Access entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EfreiDoorBundle:Access:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Access entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:Access')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Access entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EfreiDoorBundle:Access:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Access entity.
    *
    * @param Access $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Access $entity)
    {
        $form = $this->createForm(new AccessType(), $entity, array(
            'action' => $this->generateUrl('access_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Access entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EfreiDoorBundle:Access')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Access entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('access_edit', array('id' => $id)));
        }

        return $this->render('EfreiDoorBundle:Access:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Access entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EfreiDoorBundle:Access')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Access entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('access'));
    }
	
	public function deleteFromAction(Request $request, $id, $entity)
    {
       
		$em = $this->getDoctrine()->getManager();
		$access = $em->getRepository('EfreiDoorBundle:Access')->find($id);

		if (!$access) {
			throw $this->createNotFoundException('Unable to find Access entity.');
		}
		
		if($entity == 'door') {
			$rule = 'door_show';
			$entityid = $access->getDoor()->getId();
		} else if($entity == 'card') {
			$rule = 'card_show';
			$entityid = $access->getCard->getId();
		} else if($entity == 'group') {
			$rule = 'group_show';
			$entityid = $access->getGroup->getId();
		} else {
			throw $this->createNotFoundException('Entity not found in Access.');
		}
		
		$em->remove($access);
		$em->flush();
        
		
		return $this->redirect($this->generateUrl($rule, array('id'=>$entityid)));
    }

    /**
     * Creates a form to delete a Access entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('access_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
	
	public function checkAction($door, $cardcode, $facilitycode) {
	
		$em = $this->getDoctrine()->getEntityManager();
		$permission = $em->getRepository('EfreiDoorBundle:Access')->checkAccess($door, $cardcode, $facilitycode);		
		
		$response = new Response();
	
		if(count($permission) > 0) {
			$response->setStatusCode(200);
		} else {
			$response->setStatusCode(400);
		}
		
		
		return $response;
		
		
	}
}
