<?php

namespace AppBundle\Controller\Website;

use AppBundle\Manager\PageBlockManager;
use AppBundle\Manager\PageManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class XPageController extends Controller
{
    /**
     * @Route("/{slug}", name="website_page")
     * @param string $slug
     * @param PageManager $pageManager
     * @return Response
     */
    public function pageAction(string $slug, PageManager $pageManager): Response
    {
        return $this->render('website/page/view.html.twig', [
            'page' => $pageManager->getBySlug($slug)
        ]);
    }

    public function blockListAction(int $id, PageManager $pageManager, PageBlockManager $blockManager): Response
    {
        $page = $pageManager->get($id);
        $blocks = $blockManager->getList($page);
        $view = sprintf('website/page/block/_list-disposition-%s.html.twig', $page->getDisposition()->getId());

        return $this->render($view, [
            'page' => $page,
            'blocks' => $blocks,
        ]);
    }
}
