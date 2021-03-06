<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Menu;
use AppBundle\Manager\MenuManager;
use AppBundle\Manager\PageManager;
use AppBundle\Form\Type\PageType;
use Intervention\Image\ImageManagerStatic as ImageManager;
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
            $image = $page->getImage();
            if ($image) {
                $fileName = md5(uniqid(null, true)) . '.' . $image->guessExtension();
                $filePath = $this->get('kernel')->getRootDir() . '/../web/images';
                $image->move($filePath, $fileName);
                $page->setImage($fileName);

                ImageManager::make($filePath . '/' . $page->getImage())
                    ->widen(PageManager::IMAGE_WIDTH)
                    ->heighten(PageManager::IMAGE_HEIGHT)
                    ->save();
            }

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
     * @param int $id
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
     * @Route("/{id}/edit", name="admin_page_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @param MenuManager $menuManager
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request, MenuManager $menuManager): Response
    {
        $page = $this->pageManager->get($id);
        $image = $page->getImage();
        $page->setImage(null);

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        $slugBefore = $page->getSlug();
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$page->getImage()) {
                $page->setImage($image);
            } else {
                $image = $page->getImage();

                $fileName = md5(uniqid(null, true)) . '.' . $image->guessExtension();
                $filePath = $this->get('kernel')->getRootDir() . '/../web/images';
                $image->move($filePath, $fileName);
                $page->setImage($fileName);

                ImageManager::make($filePath . '/' . $page->getImage())
                    ->widen(PageManager::IMAGE_WIDTH)
                    ->heighten(PageManager::IMAGE_HEIGHT)
                    ->save();
            }
            $page = $this->pageManager->save($page);

            if ($slugBefore !== $page->getSlug()) {
                $menu = $this->getDoctrine()->getRepository(Menu::class)
                    ->findOneBy([
                        'routeSlug' => $slugBefore,
                    ]);
                $menu->setRouteSlug($page->getSlug());
                $menuManager->save($menu);
            }

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
        if (!$page->isDeletable()) {
            return $this->redirectToRoute('admin_pages');
        }

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('page-delete', $token)) {
            $this->pageManager->remove($page);
        }

        return $this->redirectToRoute('admin_pages');
    }
}
