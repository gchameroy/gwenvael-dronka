<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Manager\PageManager;
use AppBundle\Form\Type\PageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/pages")
 */
class PageController extends Controller
{
    /** @var PageManager */
    private $pageManager;

    public function __construct(PageManager $pageManager)
    {
        $this->pageManager = $pageManager;
    }

    /**
     * @Route("/", name="admin_pages")
     * @Method({"GET"})
     * @return Response
     */
    public function listAction(): Response
    {
        $pages = $this->pageManager->getList();

        return $this->render('admin/page/list.html.twig', [
            'pages' => $pages
        ]);
    }

    /**
     * @Route("/add", name="admin_pages_add")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request): Response
    {
        $page = $this->pageManager->getNew();

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $page = $this->pageManager->save($page);

            return $this->redirectToRoute('admin_page', [
                'id' => $page->getId(),
            ]);
        }

        return $this->render('admin/page/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_page", requirements={"id": "\d+"})
     * @Method({"GET"})
     * @param integer $id
     * @return Response
     */
    public function viewAction(int $id): Response
    {
        $page = $this->pageManager->get($id);

        return $this->render('admin/page/view.html.twig', [
            'page' => $page
        ]);
    }

    /**
     * @Route("/publish", name="admin_page_publish")
     * @Method({"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function publishAction(Request $request): Response
    {
        $page = $this->pageManager->get($request->request->get('id'));

        if (null !== $page->getPublishedAt()) {
            return $this->redirectToRoute('admin_pages');
        }

        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('page-publish', $token)) {
            $page->setPublishedAt(new \DateTime());
            $this->pageManager->save($page);
        }

        return $this->redirectToRoute('admin_pages');
    }

    /**
     * @Route("/un-publish", name="admin_page_un_publish")
     * @Method({"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function unPublishAction(Request $request): Response
    {
        $page = $this->pageManager->get($request->request->get('id'));

        if (null === $page->getPublishedAt()) {
            return $this->redirectToRoute('admin_pages');
        }

        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('page-unpublish', $token)) {
            $page->setPublishedAt(null);
            $this->pageManager->save($page);
        }

        return $this->redirectToRoute('admin_pages');
    }

    /**
     * @Route("/{id}/edit", name="admin_page_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $page = $this->pageManager->get($id);

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->pageManager->save($page);

            return $this->redirectToRoute('admin_page', [
                'id' => $page->getId(),
            ]);
        }

        return $this->render('admin/page/edit.html.twig', [
            'form' => $form->createView(),
            'page' => $page,
        ]);
    }

    /**
     * @Route("/delete", name="admin_page_delete")
     * @Method({"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function deleteAction(Request $request): Response
    {
        $page = $this->pageManager->get($request->request->get('id'));

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('page-delete', $token)) {
            $this->pageManager->remove($page);
        }

        return $this->redirectToRoute('admin_pages');
    }
}
