<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Task controller.
 *
 */
class TaskController extends FOSRestController
{
 
    /**
     * @Rest\Get(path="/api/task/")
     * @Rest\View()
     */
    public function getAllAction(Request $request)
    {
        $session = $request->getSession();
        $event = $session->get('activeeventid');
        
        $em = $this->getDoctrine()->getManager();

        $result = $em->getRepository('AppBundle:TaskList')->findTaskListWithTask($event, TRUE);
        return $result;
    }
 
}
