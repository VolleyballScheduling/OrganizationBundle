<?php
namespace Volleyball\Bundle\OrganizationBundle\Controller;

use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineORMAdapter;

class CouncilController extends \Volleyball\Bundle\UtilityBundle\Controller\UtilityController
{
    /**
     * @Route("/", name="volleyball_council_index")
     * @Template("VolleyballOrganizationBundle:Council:index.html.twig")
     */
    public function indexAction()
    {
        $query = $this->get('doctrine')
            ->getRepository('VolleyballOrganizationBundle:Council')
            ->findAll();

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'councils' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="volleyball_council_show")
     * @Template("VolleyballOrganizationBundle:Council:show.html.twig")
     */
    public function showAction($slug)
    {
        $council = $this->getDoctrine()
            ->getRepository('VolleyballOrganizationBundle:Council')
            ->findOneBySlug($slug);

        if (!$council) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching council found.'
                );
            $this->redirect($this->generateUrl('volleyball_council_index'));
        }

        return array('council' => $council);
    }

    /**
     * @Route("/new", name="volleyball_council_new")
     * @Template("VolleyballOrganizationBundle:Council:new.html.twig")
     */
    public function newAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $council = new \Volleyball\Bundle\OrganizationBundle\Entity\Council();
        $form = $this->createForm(
            new \Volleyball\Bundle\OrganizationBundle\Form\Type\CouncilFormType(),
            $council
        );

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($council);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'council created.'
                );

                return $this->render(
                    'VolleyballOrganizationBundle:Council:show.html.twig',
                    array(
                        'council' => $council
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}
