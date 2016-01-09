<?php
namespace Volleyball\Bundle\OrganizationBundle\Controller;

class CouncilController extends \Volleyball\Bundle\UtilityBundle\Controller\Controller
{
    /**
     * Index action
     * @inheritdoc
     */
    public function indexAction(array $councils)
    {
        return ['councils' => $this->getCouncils()];
    }

    /**
     * New action
     * @inheritdoc
     */
    public function newAction()
    {
        $council = new \Volleyball\Bundle\OrganizationBundle\Entity\Council();
        $form = $this->createBoundObjectForm($council, 'new');

        if ($form->isBound() && $form->isValid()) {
            $this->persist($council, true);
            $this->addFlash('council created');

            return $this->redirectToRoute('volleyball_councils_index');
        }

        return ['form' => $form->createView()];
    }
    
    /**
     * Search action
     * @inheritdoc
     */
    public function searchAction(array $councils)
    {
        $council = new \Volleyball\Bundle\OrganizationBundle\Entity\Council();
        $form = $this->createBoundObjectForm($council, 'search');
        
        if ($form->isBound() && $form->isValid()) {
            /** @TODO finish council search, also restrict access */
            $councils = array();

            return ['councils' => $councils];
        }

        return ['form' => $form->createView()];
    }
    
    /**
     * Show action
     * @inheritdoc
     */
    public function showAction(\Volleyball\Bundle\OrganizationBundle\Entity\Council $council)
    {
        return ['council' => $council];
    }


}
