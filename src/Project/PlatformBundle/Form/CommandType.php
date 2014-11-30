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
            ->add('send',    'submit')
            ->add('shippingDate', 'date');

        $user = $this->securityContext->getToken()->getUser();
        if (!$user) {
            throw new \LogicException(
                'Le FriendMessageFormType ne peut pas être utilisé sans utilisateur connecté!'
            );
        }

       $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($user) {
                $form = $event->getForm();

                $formOptions = array(
                    'class' => 'Project\PlatformBundle\Entity\contact',
                    'property' => 'name',
                    'query_builder' => function(ContactRepository $er) use($user){
                        return $er->createQueryBuilder('dc')
                            ->where('dc.user = :user')
                            ->setparameter('user',  $user)
                            ->orderBy('dc.user', 'ASC');
                    },
                );

                $form->add('contact', 'entity', $formOptions);
            }
        );

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