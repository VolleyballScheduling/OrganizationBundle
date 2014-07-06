<?php
namespace Volleyball\Bundle\OrganizationBundle\Controller;

use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineORMAdapter;

class OrganizationController extends \Volleyball\Bundle\UtilityBundle\Controller\UtilityController
{
    /**
     * @Route("/", name="volleyball_organization_index")
     * @Template("VolleyballOrganizationBundle:Organization:index.html.twig")
     */
    public function indexAction()
    {
        $query = $this->get('doctrine')
            ->getRepository('VolleyballOrganizationBundle:Organization')
            ->findAll();

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'organizations' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_organization_show")
     * @Template("VolleyballOrganizationBundle:Organization:show.html.twig")
     */
    public function showAction($slug)
    {
        $organization = $this->getDoctrine()
            ->getRepository('VolleyballOrganizationBundle:Organization')
            ->findOneBySlug($slug);

        if (!$organization) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching organization found.'
                );
            $this->redirect($this->generateUrl('volleyball_organization_index'));
        }

        return array('organization' => $organization);
    }

    /**
     * @Route("/new", name="volleyball_organization_new")
     * @Template("VolleyballOrganizationBundle:Organization:new.html.twig")
     */
    public function newAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $organization = new \Volleyball\Bundle\OrganizationBundle\Entity\Organization();
        $form = $this->createForm(
            new \Volleyball\Bundle\OrganizationBundle\Form\Type\OrganizationType(),
            $organization
        );

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($organization);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'organization created.'
                );

                return $this->render(
                    'VolleyballOrganizationBundle:Organization:show.html.twig',
                    array(
                        'organization' => $organization
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
