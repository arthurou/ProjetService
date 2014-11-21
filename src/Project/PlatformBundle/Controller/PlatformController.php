<?php

namespace Project\PlatformBundle\Controller;

use Project\PlatformBundle\Form\ContactType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use \Project\PlatformBundle\Entity\Contact;

class PlatformController extends Controller
{
    public function indexAction()

    {

        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')) {
            return $this->render('ProjectPlatformBundle:Platform:Home.html.twig');
        }else{
            return $this->render('ProjectPlatformBundle:Platform:Home.html.twig');
        }
    }

    public function sendAction()

    {
        return $this->render('ProjectPlatformBundle:Platform:send.html.twig');
    }


    public function contactAction(Request $request)

    {
        $contact = new Contact();
        $form = $this->get('form.factory')->create(new ContactType(), $contact);

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ProjectPlatformBundle:Contact')
        ;

        $listContact = $repository->findByUser($this->container->get('security.context')->getToken()->getUser());

        if ($form->handleRequest($request)->isValid()) {
            $user=$this->get('security.context')->getToken()->getUser();
            $contact->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->render('ProjectPlatformBundle:Platform:Contact.html.twig', array(
                'listContact' => $listContact,
                'form' => $form->createView()
            ));
        }

        return $this->render('ProjectPlatformBundle:Platform:Contact.html.twig', array(
            'listContact' => $listContact,
            'form' => $form->createView()
        ));

    }

    public function viewContactAction($uid)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('ProjectPlatformBundle:Contact')->findOneByUid($uid);

        if ($contact === null) {
            throw $this->createNotFoundException("ce contact n'existe pas");
        }

        return $this->render('ProjectPlatformBundle:Platform:viewContact.html.twig', array(
            'contact'=> $contact,
        ));
    }


    Public function adminAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->render('ProjectPlatformBundle:Platform:Home.html.twig');
        }

        return $this->render('ProjectPlatformBundle:Platform:Admin.html.twig');
    }
}