<?php
namespace Volleyball\Bundle\OrganizationBundle\Form\EventListener;

use \Symfony\Component\Form\FormEvents;

class AddRegionFieldSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    /**
     * Form factory
     * @var \Symfony\Component\Form\FormFactoryInterface
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
     * Add region form
     * @param mixed $form
     * @param mixed $council
     */
    private function addRegionForm($form, $council)
    {
        $form->add(
            $this->factory->createNamed(
                'region',
                'entity',
                null,
                array(
                    'class' => 'Volleyball\Bundle\OrganizationBundle\Entity\Region',
                    'empty_value' => '',
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) use ($council) {
                        $qb = $repository
                                ->createQueryBuilder('region')
                                ->innerJoin('region.council', 'council');
                        if ($council instanceof \Volleyball\Bundle\OrganizationBundle\Entity\Council) {
                            $qb
                                ->where('region.council = :council')
                                ->setParameter('council', $council);
                        } elseif (is_numeric($council)) {
                            $qb
                                ->where('council.id = :council')
                                ->setParameter('council', $council);
                        } else {
                            $qb
                                ->where('council.name = :council')
                                ->setParameter('council', null);
                        }
                        
                        return $qb;
                    },
                    'mapped' => $this->mapped,
                    'auto_initialize' => $this->mapped
                )
            )
        );
    }
    
    /**
     * @inheritdocs
     */
    public function preSetData(\Symfony\Component\Form\FormEvent $event)
    {
        $data = $event->getData();
 
        if (null === $data) {
            return;
        }
 
        $this->addRegionForm(
            $event->getForm(),
            (array_key_exists('region', $data) ? $data['region']->getCouncil() : null)
        );
    }
 
    /**
     * @inheritdocs
     */
    public function preBind(\Symfony\Component\Form\FormEvent $event)
    {
        $data = $event->getData();
 
        if (null === $data) {
            return;
        }
 
        $this->addRegionForm(
            $event->getForm(),
            (array_key_exists('council', $data) ? $data['council'] : null)
        );
    }
}
