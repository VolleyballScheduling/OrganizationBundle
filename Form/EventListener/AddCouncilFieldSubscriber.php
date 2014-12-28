<?php
namespace Volleyball\Bundle\OrganizationBundle\Form\EventListener;
 
use Symfony\Component\Form\FormEvents;
 
class AddCouncilFieldSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    /**
     * Form factory
     * @var type 
     */
    private $factory;
    
    /**
     * Mapped to entity
     * @var boolean
     */
    private $mapped;
 
    /**
     * Construct
     * @param \Symfony\Component\Form\FormFactoryInterface $factory
     */
    public function __construct(\Symfony\Component\Form\FormFactoryInterface $factory, $mapped = true)
    {
        $this->factory = $factory;
        $this->mapped = $mapped;
    }
 
    /**
     * Get subscribed events
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND => 'preBind'
        );
    }
 
    /**
     * Add council form
     * @param mixed $form
     * @param mixed $council
     * @param mixed $organization
     */
    private function addCouncilForm($form, $council, $organization)
    {
        $form->add(
            $this->factory->createNamed(
                'council',
                'entity',
                $council,
                array(
                    'class'         => 'Volleyball\Bundle\OrganizationBundle\Entity\Council',
                    'placeholder'   => '',
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) use ($organization) {
                        $qb = $repository
                                ->createQueryBuilder('council')
                                ->innerJoin('council.organization', 'organization');
                        
                        if ($organization instanceof \Volleyball\Bundle\OrganizationBundle\Entity\Organization) {
                            $qb->where('council.organization = :organization')
                            ->setParameter('organization', $organization);
                        } elseif (is_numeric($organization)) {
                            $qb->where('organization.id = :organization')
                            ->setParameter('organization', $organization);
                        } else {
                            $qb->where('organization.name = :organization')
                            ->setParameter('organization', null);
                        }

                        return $qb;
                    },
                    'mapped' => $this->mapped,
                    'auto_initialize' => $this->mapped
                )
            )
        );
    }
 
    public function preSetData(\Symfony\Component\Form\FormEvent $event)
    {
        $data = $event->getData();
 
        if (null === $data) {
            return;
        }
 
        $council = array_key_exists('region', $data) ? $data['region']->getCouncil() : null;
        $this->addCouncilForm(
            $event->getForm(),
            $council,
            ($council) ? $council->getOrganization() : array_key_exists('organization', $data) ? $data['organization'] : null
        );
    }
 
    public function preBind(\Symfony\Component\Form\FormEvent $event)
    {
        $data = $event->getData();
 
        if (null === $data) {
            return;
        }
 
        $this->addCouncilForm(
            $event->getForm(),
            array_key_exists('council', $data) ? $data['council'] : null,
            array_key_exists('organization', $data) ? $data['organization'] : null
        );
    }
}
