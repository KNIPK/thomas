<?php

namespace Kni\ThomasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kni\ThomasBundle\Entity\File;
use Kni\ThomasBundle\Form\FileType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * File controller.
 *
 * @Route("/profile/files")
 */
class FileController extends Controller
{
    
    private $workshopId;
        /**
     * Lists all File entities.
     *
     * @Route("/{workshopId}/", name="profile_files")
     * @Route("/{workshopId}/edit", name="profile_files_edit")
         * it's used when workshop's editing (in view is other menu)
     * @Method("GET")
     * @Template()
     */
    public function indexAction($workshopId)
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        if($routeName=='profile_files_edit')
            $isEditWorkshop=true;
        
        $this->workshopId = $workshopId;
        $this->checkAccess();
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KniThomasBundle:File')->findBy(array('workshop'=>$workshopId));

        return array(
            'entities' => $entities,
            'workshopId' => $workshopId,
            'isEditWorkshop' => $isEditWorkshop,
        );
    }

    /**
     * Creates a new File entity.
     *
     * @Route("/{workshopId}/", name="profile_files_create")
     * @Method("POST")
     * @Template("KniThomasBundle:File:new.html.twig")
     */
    public function createAction(Request $request, $workshopId)
    {
        $this->workshopId = $workshopId;
        $this->checkAccess();
        
        $entity  = new File();
        $form = $this->createForm(new FileType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            //zapisujemy id warsztatów
            $entity->setWorkshop($em->getRepository('KniThomasBundle:Workshop')->find($workshopId));
            $file = $form['path']->getData();
            
            //przenosimy plik do odpowiedniej lokalizacji i zapisujemy nazwe
            $randomNumber = rand(1, 99999);
            $file->move($entity->getUploadRootDir(), $randomNumber."_".$file->getClientOriginalName());
            $entity->setPath($randomNumber."_".$file->getClientOriginalName());
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('profile_files', array('workshopId' => $workshopId)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'workshopId' => $workshopId,
        );
    }

    /**
     * Displays a form to create a new File entity.
     *
     * @Route("/{workshopId}/new", name="profile_files_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($workshopId)
    {
        $this->workshopId = $workshopId;
        $this->checkAccess();
        
        $entity = new File();
        $form   = $this->createForm(new FileType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'workshopId' => $workshopId
        );
    }

    /**
     * Finds and displays a File entity.
     *
     * @Route("/{id}", name="profile_files_show")
     * @Method("GET")
     * @Template()
     */
    /*public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KniThomasBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }*/

    /**
     * Displays a form to edit an existing File entity.
     *
     * @Route("/{id}/edit", name="profile_files_edit")
     * @Method("GET")
     * @Template()
     */
    /*public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KniThomasBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $editForm = $this->createForm(new FileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }*/

    /**
     * Edits an existing File entity.
     *
     * @Route("/{id}", name="profile_files_update")
     * @Method("PUT")
     * @Template("KniThomasBundle:File:edit.html.twig")
     */
    /*public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KniThomasBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FileType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('profile_files_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }*/

    /**
     * Deletes a File entity.
     *
     * @Route("/{workshopId}/{id}/delete", name="profile_files_delete")
     */
    public function deleteAction(Request $request, $workshopId, $id)
    {
        $this->workshopId = $workshopId;
        $this->checkAccess();
        
        
        
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KniThomasBundle:File')->findOneBy(array(
            'id' => $id, 
            'workshop' => $workshopId
        ));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $fs = new Filesystem();
        if($fs->exists($entity->getAbsolutePath()))
            $fs->remove($entity->getAbsolutePath());

        $em->remove($entity);
        $em->flush();

        
        return $this->redirect($this->generateUrl('profile_files', array('workshopId' => $workshopId)));
    }

    /**
     * Creates a form to delete a File entity by id.
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
    
    private function checkAccess(){
        $em = $this->getDoctrine()->getManager();
        $workshop = $em->getRepository('KniThomasBundle:Workshop')->findOneBy(array(
            'id' => $this->workshopId,
            'user' => $this->get('security.context')->getToken()->getUser()
        ));
        if(!$workshop){
            throw new AccessDeniedException();
        }
    }
}
