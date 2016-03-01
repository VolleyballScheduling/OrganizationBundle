<?php
namespace Volleyball\Bundle\OrganizationBundle\Controller;

class RegionController extends \Volleyball\Bundle\UtilityBundle\Controller\Controller
{
    /**
     * Index action
     * @inheritdoc
     */
    public function indexAction(array $regions)
    {
        return ['regions' => $this->getRegions()];
    }

    /**
     * New action
     * @inheritdoc
     */
    public function newAction()
    {
        $region = new \Volleyball\Bundle\OrganizationBundle\Entity\Region();
        $form = $this->createBoundObjectForm($region, 'new');

        if ($form->isBound() && $form->isValid()) {
            $this->persist($region, true);
            $this->addFlash('region created');

            return $this->redirectToRoute('volleyball_regions_index');
        }

        return ['form' => $form->createView()];
    }
    
    /**
     * Search action
     * @inheritdoc
     */
    public function searchAction(array $regions)
    {
        $region = new \Volleyball\Bundle\OrganizationBundle\Entity\Region();
        $form = $this->createBoundObjectForm($region, 'search');
        
        if ($form->isBound() && $form->isValid()) {
            /** @TODO finish region search, also restrict access */
            $regions = array();

            return ['regions' => $regions];
        }

        return ['form' => $form->createView()];
    }
    
    /**
     * Show action
     * @inheritdoc
     */
    public function showAction(\Volleyball\Bundle\OrganizationBundle\Entity\Region $region)
    {
        return ['region' => $region];
    }
}
