<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Manager\PageStaticManager;
use AppBundle\Form\Type\PageStaticType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/seo")
 */
class PageStaticController extends Controller
{
    /** @var PageStaticManager */
    private $pageStaticManager;

    public function __construct(PageStaticManager $pageStaticManager)
    {
        $this->pageStaticManager = $pageStaticManager;
    }

    /**
     * @Route("/", name="admin_seo")
     * @Method({"GET"})
     * @return Response
     */
    public function listAction(): Response
    {
        $pagesStatic = $this->pageStaticManager->getList();

        return $this->render('admin/seo/list.html.twig', [
            'pagesStatic' => $pagesStatic
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_seo_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $pageStatic = $this->pageStaticManager->get($id);

        $form = $this->createForm(PageStaticType::class, $pageStatic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pageStaticManager->save($pageStatic);

            return $this->redirectToRoute('admin_seo');
        }

        return $this->render('admin/seo/edit.html.twig', [
            'form' => $form->createView(),
            'pageStatic' => $pageStatic,
        ]);
    }
}
