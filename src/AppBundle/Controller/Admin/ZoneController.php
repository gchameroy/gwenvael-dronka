<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\Type\ZoneType;
use AppBundle\Manager\ZoneManager;
use AppBundle\Utils\GoogleMaps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/zones")
 */
class ZoneController extends Controller
{
    /** @var ZoneManager */
    private $zoneManager;

    public function __construct(ZoneManager $zoneManager)
    {
        $this->zoneManager = $zoneManager;
    }

    /**
     * @Route("/", name="admin_zones")
     * @Method({"GET"})
     * @return Response
     */
    public function listAction(): Response
    {
        return $this->render('admin/zone/list.html.twig', [
            'zones' => $this->zoneManager->getList()
        ]);
    }

    /**
     * @Route("/add", name="admin_zones_add")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param GoogleMaps $gmaps
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request, GoogleMaps $gmaps): Response
    {
        $zone = $this->zoneManager->getNew();

        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $location = $gmaps->geoLocateAddress($zone->getAddress()->getFormattedAddress());
            if ($location) {
                $zone->getAddress()->setLatitude($location->getLat());
                $zone->getAddress()->setLongitude($location->getLng());
            }
            $this->zoneManager->save($zone);

            return $this->redirectToRoute('admin_zones');
        }

        return $this->render('admin/zone/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_zone_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param $id
     * @param Request $request
     * @param GoogleMaps $gmaps
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request, GoogleMaps $gmaps): Response
    {
        $zone = $this->zoneManager->get($id);

        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $location = $gmaps->geoLocateAddress($zone->getAddress()->getFormattedAddress());
            if ($location) {
                $zone->getAddress()->setLatitude($location->getLat());
                $zone->getAddress()->setLongitude($location->getLng());
            }
            $this->zoneManager->save($zone);

            return $this->redirectToRoute('admin_zones');
        }

        return $this->render('admin/zone/edit.html.twig', [
            'form' => $form->createView(),
            'zone' => $zone,
        ]);
    }

    /**
     * @Route("/delete", name="admin_zone_delete")
     * @Method({"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function deleteAction(Request $request): Response
    {
        $zone = $this->zoneManager->get($request->request->get('id'));

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('zone-delete', $token)) {
            $this->zoneManager->remove($zone);
        }

        return $this->redirectToRoute('admin_zones');
    }
}
