<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;

/**
 * Task controller.
 *
 */
class TaskController extends FOSRestController
{
 
    /**
     * @Rest\Get(path="/api/task")
     * @Rest\View()
     */
    public function getAllAction(Request $request)
    {
        $session = $request->getSession();
        $event = $session->get('activeeventid');
        
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('AppBundle:TaskList')->findByEvent($event);
    }
 
}
