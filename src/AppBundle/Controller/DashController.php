<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashController extends Controller
{
    /**
     * @Route("/dash/{eventId}", name="dash", defaults={"eventId" = NULL})
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
        
        
        return $this->render('dash/index.html.twig');
    }
}