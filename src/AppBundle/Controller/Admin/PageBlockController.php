<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\Type\PageBlockType;
use AppBundle\Manager\PageBlockManager;
use AppBundle\Manager\PageManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/pages")
 */
class PageBlockController extends Controller
{
    /** @var PageManager */
    private $pageManager;

    /** @var PageBlockManager */
    private $blockManager;

    public function __construct(PageManager $pageManager, PageBlockManager $blockManager)
    {
        $this->pageManager = $pageManager;
        $this->blockManager = $blockManager;
    }

    /**
     * @Route("/{id}/blocks", name="admin_page_blocks", requirements={"id": "\d+"})
     * @Method({"GET"})
     * @param int $id
     * @return Response
     */
    public function listAction(int $id): Response
    {
        $page = $this->pageManager->get($id);
        $blocks = $this->blockManager->getList($page);

        return $this->render('admin/page/block/_list.html.twig', [
            'page' => $page,
            'blocks' => $blocks,
        ]);
    }

    /**
     * @Route("/{id}/blocks/add", name="admin_page_blocks_add", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(int $id, Request $request): Response
    {
        $page = $this->pageManager->get($id);
        $block = $this->blockManager->getNew($page);

        $form = $this->createForm(PageBlockType::class, $block);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $block = $this->blockManager->save($block);

            return $this->redirectToRoute('admin_page', [
                'id' => $block->getPage()->getId(),
            ]);
        }

        return $this->render('admin/page/block/add.html.twig', [
            'form' => $form->createView(),
            'page' => $page,
        ]);
    }

    /**
     * @Route("/blocks/{id}/edit", name="admin_page_block_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $block = $this->blockManager->get($id);

        $form = $this->createForm(PageBlockType::class, $block);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->blockManager->save($block);

            return $this->redirectToRoute('admin_page', [
                'id' => $block->getPage()->getId(),
            ]);
        }

        return $this->render('admin/page/block/edit.html.twig', [
            'form' => $form->createView(),
            'block' => $block,
        ]);
    }

    /**
     * @Route("/{id}/blocks/delete", name="admin_page_block_delete")
     * @Method({"POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function deleteAction(int $id, Request $request): Response
    {
        $page = $this->pageManager->get($id);
        if (!$page) {
            return $this->redirectToRoute('admin_pages');
        }
        $block = $this->blockManager->get($request->request->get('id'), false);

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('page-block-delete', $token)) {
            $this->blockManager->remove($block);
        }

        return $this->redirectToRoute('admin_page', [
            'id' => $page->getId(),
        ]);
    }
}
