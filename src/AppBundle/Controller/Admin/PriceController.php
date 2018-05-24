<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Price;
use AppBundle\Form\Type\PriceType;
use AppBundle\Manager\PriceManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/prices")
 */
class PriceController extends Controller
{
    /** @var PriceManager */
    private $priceManager;

    public function __construct(PriceManager $priceManager)
    {
        $this->priceManager = $priceManager;
    }

    /**
     * @Route("/", name="admin_prices")
     * @Method({"GET"})
     * @return Response
     */
    public function listAction(): Response
    {
        return $this->render('admin/price/list.html.twig', [
            'prices' => $this->priceManager->getList(),
            'offers' => $this->priceManager->getOffers()
        ]);
    }

    /**
     * @Route("/add", name="admin_prices_add")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request): Response
    {
        $offer = $this->priceManager->getNew();

        return $this->addPrice($offer, $request);
    }

    /**
     * @Route("/add-offer", name="admin_prices_add_offer")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addOfferAction(Request $request): Response
    {
        $offer = $this->priceManager->getNewOffer();

        return $this->addPrice($offer, $request);
    }

    private function addPrice(Price $price, Request $request): Response
    {
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->priceManager->save($price);

            return $this->redirectToRoute('admin_prices');
        }

        $view = 'admin/price/add.html.twig';
        if ($price->isOffer()) {
            $view = 'admin/price/add-offer.html.twig';
        }

        return $this->render($view, [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_price_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $price = $this->priceManager->get($id);

        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->priceManager->save($price);

            return $this->redirectToRoute('admin_prices');
        }

        return $this->render('admin/price/edit.html.twig', [
            'form' => $form->createView(),
            'price' => $price,
        ]);
    }

    /**
     * @Route("/delete", name="admin_price_delete")
     * @Method({"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function deleteAction(Request $request): Response
    {
        $price = $this->priceManager->get($request->request->get('id'));

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('price-delete', $token)) {
            $this->priceManager->remove($price);
        }

        return $this->redirectToRoute('admin_prices');
    }
}
