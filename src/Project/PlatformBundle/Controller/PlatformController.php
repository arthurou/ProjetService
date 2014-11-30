<?php

namespace Project\PlatformBundle\Controller;

use Project\PlatformBundle\Entity\Command;
use \Project\PlatformBundle\Entity\Contact;
use Project\PlatformBundle\Form\ContactType;
use Project\PlatformBundle\Form\CommandType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



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

    public function sendAction(Request $request)

    {

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ProjectPlatformBundle:Contact')
        ;

        $securityContext = $this->container->get('security.context');

        $command = new Command();
        $listContact = $repository->findByUser($securityContext->getToken()->getUser());
        $commandForm = $this->get('form.factory')->create(new CommandType( $securityContext), $command);


        if ($commandForm->handleRequest($request)->isValid()) {
            $user=$this->get('security.context')->getToken()->getUser();
            $command->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($command);
            $em->flush();

            return $this->render('ProjectPlatformBundle:Platform:Send.html.twig', array(
                'listContact' => $listContact,
                'commandForm' => $commandForm->createView()
            ));
        }

        return $this->render('ProjectPlatformBundle:Platform:Send.html.twig', array(
            'listContact' => $listContact,
            'commandForm' => $commandForm->createView()
        ));
    }


    public function contactAction(Request $request)

    {
        $contact = new Contact();
        $contactForm = $this->get('form.factory')->create(new ContactType(), $contact);

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ProjectPlatformBundle:Contact')
        ;

        $listContact = $repository->findByUser($this->container->get('security.context')->getToken()->getUser());

        if ($contactForm->handleRequest($request)->isValid()) {
            $user=$this->get('security.context')->getToken()->getUser();
            $contact->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->render('ProjectPlatformBundle:Platform:Contact.html.twig', array(
                'listContact' => $listContact,
                'contactForm' => $contactForm->createView()
            ));
        }

        return $this->render('ProjectPlatformBundle:Platform:Contact.html.twig', array(
            'listContact' => $listContact,
            'contactForm' => $contactForm->createView()
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

    Public function productionAction()
    {
        return $this->render('ProjectPlatformBundle:Platform:production.html.twig');
    }
}