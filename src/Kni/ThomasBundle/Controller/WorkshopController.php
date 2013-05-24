<?php

namespace Kni\ThomasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kni\ThomasBundle\Entity\Workshop;
use Kni\ThomasBundle\Form\WorkshopType;

/**
 * Workshop controller.
 *
 * @Route("/profile/workshop")
 */
class WorkshopController extends Controller
{
    /**
     * Lists all Workshop entities.
     *
     * @Route("/", name="profile_workshop")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KniThomasBundle:Workshop')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Workshop entity.
     *
     * @Route("/", name="profile_workshop_create")
     * @Method("POST")
     * @Template("KniThomasBundle:Workshop:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Workshop();
        $form = $this->createForm(new WorkshopType($this->get('security.context')->getToken()->getUser()), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            //w pole user dodajemy aktualnie zalogowanego użytkownika
            $entity->setUser($this->get('security.context')->getToken()->getUser());
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('profile_files', array('workshopId' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Workshop entity.
     *
     * @Route("/new", name="profile_workshop_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Workshop();
        $form   = $this->createForm(new WorkshopType($this->get('security.context')->getToken()->getUser()), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Workshop entity.
     *
     * @Route("/{id}", name="profile_workshop_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KniThomasBundle:Workshop')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Workshop entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Workshop entity.
     *
     * @Route("/{id}/edit", name="profile_workshop_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KniThomasBundle:Workshop')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Workshop entity.');
        }


        $editForm = $this->createForm(new WorkshopType($this->get('security.context')->getToken()->getUser()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Workshop entity.
     *
     * @Route("/{id}", name="profile_workshop_update")
     * @Method("PUT")
     * @Template("KniThomasBundle:Workshop:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KniThomasBundle:Workshop')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Workshop entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new WorkshopType($this->get('security.context')->getToken()->getUser()), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('profile_workshop_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Workshop entity.
     *
     * @Route("/{id}", name="profile_workshop_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KniThomasBundle:Workshop')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Workshop entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('profile_workshop'));
    }

    /**
     * Creates a form to delete a Workshop entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Podsumowanie dodawania warsztatów
     *
     * @Route("/{workshopId}/added", name="profile_workshop_added")
     * @Template()
     */
    public function addedAction($workshopId){
        return array(
            'workshopId' => $workshopId,
        );
    }
}
