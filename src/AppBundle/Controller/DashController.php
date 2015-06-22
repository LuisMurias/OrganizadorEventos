<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Form\EventType;

class DashController extends Controller
{
    /**
     * @Route("/dash/{eventId}", name="dash", defaults={"eventId" = NULL})
     * @Template()
     */
    public function indexAction($eventId, Request $request)
    {
        $session = $request->getSession();
        
        if($eventId || $session->get('activeeventid') == NULL){
            $user = $this->get('security.token_storage')->getToken()->getUser();
            
            $em = $this->getDoctrine()->getManager();
            $event = NULL;
            if($eventId){
                $event = $em->getRepository('AppBundle:Event')->find($eventId);
            }else{
                $events = $em->getRepository('AppBundle:Event')->findByOwner($user->getId());
                if(count($events) > 0){
                    $event = $events[0];
                }
            }
            
            if (!$event) {
                throw $this->createNotFoundException('Unable to find Event entity.');
            }
            $session->set('activeeventid', $event->getId());
            $session->set('activeeventname', $event->getName());
        }
        
        $eventForm = $this->createForm(new EventType());
        $eventForm->add('submit', 'submit', array('label' => 'Guardar'));
        
        return array(
            'event_form' => $eventForm->createView(),
        );
        //return $this->render('dash/index.html.twig');
    }
    
    
    /**
     * Lists all Task entities.
     *
     * @Route("/task", name="task")
     * @Method("GET")
     * @Template()
     */
    public function taskAction(Request $request)
    {
        $session = $request->getSession();
        $event = $session->get('activeeventid');
        
        $em = $this->getDoctrine()->getManager();

        $tasklists = $em->getRepository('AppBundle:TaskList')->findByEvent($event);

        return array(
            'tasklists' => $tasklists,
        );
    }
    
     /**
     * Lists my Event entities.
     *
     * @Route("/menu", name="event_menu")
     * @Method("GET")
     * @Template()
     */
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $events = $em->getRepository('AppBundle:Event')->findByOwner($user->getId());

        return array(
            'events' => $events,
        );
    }
    
    
}