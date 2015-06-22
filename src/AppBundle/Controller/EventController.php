<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use AppBundle\Entity\Event;
use AppBundle\Form\EventType;

/**
 * Task controller.
 *
 */
class EventController extends FOSRestController
{
 
    /**
     * @Rest\Get(path="/api/eventstats/")
     * @Rest\View()
     */
    public function getEventStatsAction(Request $request)
    {
        $session = $request->getSession();
        $event = $session->get('activeeventid');
        
        $em = $this->getDoctrine()->getManager();

        $result = $em->getRepository('AppBundle:Event')->find($event);
        return $result;
    }
 
     /**
     * @Rest\Post(path="/api/event/")
     * @Rest\View()
     */
    public function postEventAction(Request $request)
    {
        $entity = new Event();
        $form = $this->createForm(new EventType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $entity->setOwner($user);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('evento_show', array('id' => $entity->getId())));
        }
        return array(
            'form' => $form
        );
        
        
        
//        $session = $request->getSession();
//        $event = $session->get('activeeventid');
//        
//        $em = $this->getDoctrine()->getManager();
//
//        $result = $em->getRepository('AppBundle:Event')->find($event);
//        return $result;
    }
    
}
