<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\Type\MenuType;
use AppBundle\Manager\MenuManager;
use AppBundle\Manager\PageManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/menus")
 */
class MenuController Extends Controller
{
    /** @var MenuManager */
    private $menuManager;

    /** @var PageManager */
    private $pageManager;

    public function __construct(MenuManager $menuManager, PageManager $pageManager)
    {
        $this->menuManager = $menuManager;
        $this->pageManager = $pageManager;
    }

    /**
     * @Route("/", name="admin_menus")
     * @return Response
     */
    public function listAction(): Response
    {
        $menus = $this->menuManager->getList();

        return $this->render('admin/menu/list.html.twig', [
            'menus' => $menus
        ]);
    }

    /**
     * @Route("/add", name="admin_menus_add")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request): Response
    {
        $menu = $this->menuManager->getNew();

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->menuManager->save($menu);

            return $this->redirectToRoute('admin_menus');
        }

        $pages = $this->pageManager->getList();

        return $this->render('admin/menu/add.html.twig', [
            'form' => $form->createView(),
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_menu_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $menu = $this->menuManager->get($id);

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->menuManager->save($menu);

            return $this->redirectToRoute('admin_menus');
        }

        $pages = $this->pageManager->getList();

        return $this->render('admin/menu/edit.html.twig', [
            'form' => $form->createView(),
            'menu' => $menu,
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/move", name="admin_menu_move")
     * @Method({"POST"})
     * @param Request $request
     * @return RedirectResponse
     */
    public function moveAction(Request $request): RedirectResponse
    {
        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('menu-move', $token)) {
            $menu = $this->menuManager->get($request->request->get('id'));
            $direction = $request->request->get('direction');

            $this->menuManager->move($menu, $direction);
        }

        return $this->redirectToRoute('admin_menus');
    }

    /**
     * @Route("/delete", name="admin_menu_delete")
     * @Method({"POST"})
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request): RedirectResponse
    {
        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('menu-remove', $token)) {
            $menu = $this->menuManager->get($request->request->get('id'), false);

            $this->menuManager->remove($menu);
        }

        return $this->redirectToRoute('admin_menus');
    }
}
