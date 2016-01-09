<?php
namespace Volleyball\Bundle\OrganizationBundle\Controller;

class OrganizationController extends \Volleyball\Bundle\UtilityBundle\Controller\Controller
{
    /**
     * Index action
     * @inheritdoc
     */
    public function indexAction(array $organizations)
    {
        return ['organizations' => $this->getOrganizations()];
    }

    /**
     * New action
     * @inheritdoc
     */
    public function newAction()
    {
        $organization = new \Volleyball\Bundle\OrganizationBundle\Entity\Organization();
        $form = $this->createBoundObjectForm($organization, 'new');

        if ($form->isBound() && $form->isValid()) {
            $this->persist($organization, true);
            $this->addFlash('organization created');

            return $this->redirectToRoute('volleyball_organizations_index');
        }

        return ['form' => $form->createView()];
    }
    
    /**
     * Search action
     * @inheritdoc
     */
    public function searchAction(array $organizations)
    {
        $organization = new \Volleyball\Bundle\OrganizationBundle\Entity\Organization();
        $form = $this->createBoundObjectForm($organization, 'search');
        
        if ($form->isBound() && $form->isValid()) {
            /** @TODO finish organization search, also restrict access */
            $organizations = array();

            return ['organizations' => $organizations];
        }

        return ['form' => $form->createView()];
    }
    
    /**
     * Show action
     * @inheritdoc
     */
    public function showAction(\Volleyball\Bundle\OrganizationBundle\Entity\Organization $organization)
    {
        return ['organization' => $organization];
    }


}
