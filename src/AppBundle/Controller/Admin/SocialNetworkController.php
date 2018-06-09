<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\Type\SettingSocialNetworkType;
use AppBundle\Manager\SettingSocialNetworkManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/social-networks")
 */
class SocialNetworkController extends Controller
{
    /** @var SettingSocialNetworkManager */
    private $manager;

    public function __construct(SettingSocialNetworkManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="admin_social_networks")
     * @Method({"GET"})
     * @return Response
     */
    public function listAction(): Response
    {
        return $this->render('admin/social-network/list.html.twig', [
            'socialNetworks' => $this->manager->getList()
        ]);
    }

    /**
     * @Route("/add", name="admin_social_networks_add")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request): Response
    {
        $settingSocialNetwork = $this->manager->getNew();

        $form = $this->createForm(SettingSocialNetworkType::class, $settingSocialNetwork);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->save($settingSocialNetwork);

            return $this->redirectToRoute('admin_social_networks');
        }

        return $this->render('admin/social-network/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_social_network_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $settingSocialNetwork = $this->manager->get($id);

        $form = $this->createForm(SettingSocialNetworkType::class, $settingSocialNetwork);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->save($settingSocialNetwork);

            return $this->redirectToRoute('admin_social_networks');
        }

        return $this->render('admin/social-network/edit.html.twig', [
            'form' => $form->createView(),
            'socialNetwork' => $settingSocialNetwork,
        ]);
    }

    /**
     * @Route("/delete", name="admin_social_network_delete")
     * @Method({"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function deleteAction(Request $request): Response
    {
        $settingSocialNetwork = $this->manager->get($request->request->get('id'));

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('social-network-delete', $token)) {
            $this->manager->remove($settingSocialNetwork);
        }

        return $this->redirectToRoute('admin_social_networks');
    }
}
