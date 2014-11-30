<?php

namespace Project\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use \Project\PlatformBundle\Entity\ContactRepository;

class CommandType extends AbstractType
{

    private $securityContext;


    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commandNumber',    'text')
            ->add('status',    'text');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Project\PlatformBundle\Entity\Command'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Project_PlatformBundle_send';
    }

    public function getContactList()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ProjectPlatformBundle:Contact')
        ;

        $securityContext = $this->container->get('security.context');
        return  $repository->findByUser($securityContext->getToken()->getUser());
    }
}