<?php

namespace Project\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PlatformController extends Controller
{
    public function indexAction()

    {
        return $this->render('ProjectPlatformBundle:Platform:Home.html.twig');
    }

    public function sendAction()

    {
        return $this->render('ProjectPlatformBundle:Platform:send.html.twig');
    }


    public function contactAction()

    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->render('ProjectPlatformBundle:Platform:contact.html.twig');
        }
        else{
            return $this->redirect($this->generateUrl('project_platform_homepage'));
        }
    }



    Public function adminAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->render('ProjectPlatformBundle:Platform:Home.html.twig');
        }

        return $this->render('ProjectPlatformBundle:Platform:Admin.html.twig');
    }
}