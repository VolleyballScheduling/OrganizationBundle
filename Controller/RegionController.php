<?php
namespace Volleyball\Bundle\OrganizationBundle\Controller;

use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Request;
use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineORMAdapter;

class RegionController extends \Volleyball\Bundle\UtilityBundle\Controller\UtilityController
{
    /**
     * @Route("/", name="volleyball_region_index")
     * @Template("VolleyballOrganizationBundle:Region:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('VolleyballOrganizationBundle:Region')
            ->findAll();

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'regions' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_region_show")
     * @Template("VolleyballOrganizationBundle:Region:show.html.twig")
     */
    public function showAction(Request $request)
    {
        $slug = $request->getParameter('slug');
        $region = $this->getDoctrine()
            ->getRepository('VolleyballOrganizationBundle:Region')
            ->findOneBySlug($slug);

        if (!$region) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching region found.'
                );
            $this->redirect($this->generateUrl('volleyball_region_index'));
        }

        return array('region' => $region);
    }

    /**
     * @Route("/new", name="volleyball_region_new")
     * @Template("VolleyballOrganizationBundle:Region:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $region = new \Volleyball\Bundle\OrganizationBundle\Entity\Region();
        $form = $this->createForm(
            new \Volleyball\Bundle\OrganizationBundle\Form\Type\RegionFormType(),
            $region
        );

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($region);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'region created.'
                );

                return $this->render(
                    'VolleyballOrganizationBundle:Region:show.html.twig',
                    array(
                        'region' => $region
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
