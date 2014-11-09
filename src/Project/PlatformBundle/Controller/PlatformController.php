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

    Public function adminAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->render('ProjectPlatformBundle:Platform:Home.html.twig');
        }

        return $this->render('ProjectPlatformBundle:Platform:Admin.html.twig');
    }
}