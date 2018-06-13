<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\Type\PriceImageType;
use AppBundle\Manager\PriceImageManager;
use AppBundle\Manager\PriceManager;
use Intervention\Image\ImageManagerStatic as ImageManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/prices")
 */
class PriceImageController extends Controller
{
    /** @var PriceManager */
    private $priceManager;

    /** @var PriceImageManager */
    private $imageManager;

    public function __construct(PriceManager $priceManager, PriceImageManager $imageManager)
    {
        $this->priceManager = $priceManager;
        $this->imageManager = $imageManager;
    }

    /**
     * @Route("/{id}/images", name="admin_price_images", requirements={"id": "\d+"})
     * @Method({"GET"})
     * @param int $id
     * @return Response
     */
    public function listAction(int $id): Response
    {
        $price = $this->priceManager->get($id);
        $images = $this->imageManager->getList($price);

        return $this->render('admin/price/image/list.html.twig', [
            'price' => $price,
            'images' => $images,
        ]);
    }

    /**
     * @Route("/{id}/images/add", name="admin_price_images_add", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(int $id, Request $request): Response
    {
        $price = $this->priceManager->get($id);
        $image = $this->imageManager->getNew($price);

        $form = $this->createForm(PriceImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $image->getPath();

            $fileName = md5(uniqid(null, true)) . '.' . $file->guessExtension();
            $filePath = $this->get('kernel')->getRootDir() . '/../web/images';
            $file->move($filePath, $fileName);
            $image->setPath($fileName);

            ImageManager::make($filePath . '/' . $image->getPath())
                ->widen(PriceImageManager::IMAGE_WIDTH)
                ->heighten(PriceImageManager::IMAGE_HEIGHT)
                ->save();

            $image = $this->imageManager->save($image);

            return $this->redirectToRoute('admin_price_images', [
                'id' => $image->getPrice()->getId(),
            ]);
        }

        return $this->render('admin/price/image/add.html.twig', [
            'form' => $form->createView(),
            'price' => $price,
        ]);
    }

    /**
     * @Route("/images/{id}/edit", name="admin_price_image_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $image = $this->imageManager->get($id)
            ->setPath(null);

        $form = $this->createForm(PriceImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $image->getPath();

            $fileName = md5(uniqid(null, true)) . '.' . $file->guessExtension();
            $filePath = $this->get('kernel')->getRootDir() . '/../web/images';
            $file->move($filePath, $fileName);
            $image->setPath($fileName);

            ImageManager::make($filePath . '/' . $image->getPath())
                ->widen(PriceImageManager::IMAGE_WIDTH)
                ->heighten(PriceImageManager::IMAGE_HEIGHT)
                ->save();

            $this->imageManager->save($image);

            return $this->redirectToRoute('admin_price_images', [
                'id' => $image->getPrice()->getId(),
            ]);
        }

        return $this->render('admin/price/image/edit.html.twig', [
            'form' => $form->createView(),
            'image' => $image,
        ]);
    }

    /**
     * @Route("/{id}/images/delete", name="admin_price_image_delete")
     * @Method({"POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function deleteAction(int $id, Request $request): Response
    {
        $price = $this->priceManager->get($id, false);
        if (!$price) {
            return $this->redirectToRoute('admin_prices');
        }
        $image = $this->imageManager->get($request->request->get('id'), false);

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('price-image-delete', $token)) {
            $this->imageManager->remove($image);
        }

        return $this->redirectToRoute('admin_price_images', [
            'id' => $price->getId(),
        ]);
    }
}
