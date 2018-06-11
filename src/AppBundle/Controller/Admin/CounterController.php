<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\Type\SettingCounterType;
use AppBundle\Manager\SettingCounterManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/counters")
 */
class CounterController extends Controller
{
    /** @var SettingCounterManager */
    private $settingCounterManager;

    public function __construct(SettingCounterManager $manager)
    {
        $this->settingCounterManager = $manager;
    }

    public function _listAction(): Response
    {
        return $this->render('admin/counter/_list.html.twig', [
            'settingCounters' => $this->settingCounterManager->getList()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_counter_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $settingCounter = $this->settingCounterManager->get($id);

        $form = $this->createForm(SettingCounterType::class, $settingCounter);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->settingCounterManager->save($settingCounter);

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/counter/edit.html.twig', [
            'form' => $form->createView(),
            'settingCounter' => $settingCounter,
        ]);
    }
}
