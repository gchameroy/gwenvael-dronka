<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\Type\PageBlockImageType;
use AppBundle\Manager\PageBlockImageManager;
use AppBundle\Manager\PageBlockManager;
use Intervention\Image\ImageManagerStatic as Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageBlockImageController extends Controller
{
    /** @var PageBlockManager */
    private $blockManager;

    /** @var PageBlockImageManager */
    private $imageManager;

    public function __construct(PageBlockManager $blockManager, PageBlockImageManager $imageManager)
    {
        $this->blockManager = $blockManager;
        $this->imageManager = $imageManager;
    }

    /**
     * @Route("/blocks/{id}/images", name="admin_page_block_images", requirements={"id": "\d+"})
     * @Method({"GET"})
     * @param int $id
     * @return Response
     */
    public function listAction(int $id): Response
    {
        $block = $this->blockManager->get($id);
        $images = $this->imageManager->getList($block);

        return $this->render('admin/page/block/image/_list.html.twig', [
            'block' => $block,
            'images' => $images,
        ]);
    }

    /**
     * @Route("/blocks/{id}/images/manager", name="admin_page_block_images_manager", requirements={"id": "\d+"})
     * @Method({"GET"})
     * @param int $id
     * @return Response
     */
    public function managerAction(int $id): Response
    {
        $block = $this->blockManager->get($id);
        $images = $this->imageManager->getList($block);

        return $this->render('admin/page/block/image/list.html.twig', [
            'block' => $block,
            'images' => $images,
        ]);
    }

    /**
     * @Route("/blocks/{id}/images/add", name="admin_page_block_images_add", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(int $id, Request $request): Response
    {
        $block = $this->blockManager->get($id);
        $image = $this->imageManager->getNew($block);

        $form = $this->createForm(PageBlockImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $image->getPath();

            $fileName = md5(uniqid(null, true));
            $filePath = $this->get('kernel')->getRootDir() . '/../uploads/page-block-image';
            $file->move($filePath, $fileName);
            $image->setPath($fileName);

            Image::make($filePath . '/' . $image->getPath())
                ->resize(650, 433)
                ->save();

            $image = $this->imageManager->save($image);

            return $this->redirectToRoute('admin_page_block_images_manager', [
                'id' => $image->getBlock()->getId(),
            ]);
        }

        return $this->render('admin/page/block/image/add.html.twig', [
            'form' => $form->createView(),
            'block' => $block,
        ]);
    }

    /**
     * @Route("/images/{id}/edit", name="admin_page_block_image_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $image = $this->imageManager->get($id)
            ->setPath(null);

        $form = $this->createForm(PageBlockImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $image->getPath();

            $fileName = md5(uniqid(null, true));
            $filePath = $this->get('kernel')->getRootDir() . '/../uploads/page-block-image';
            $file->move($filePath, $fileName);
            $image->setPath($fileName);

            Image::make($filePath . '/' . $image->getPath())
                ->resize(650, 433)
                ->save();

            $this->imageManager->save($image);

            return $this->redirectToRoute('admin_page_block_images_manager', [
                'id' => $image->getBlock()->getId(),
            ]);
        }

        return $this->render('admin/page/block/image/edit.html.twig', [
            'form' => $form->createView(),
            'image' => $image,
        ]);
    }

    /**
     * @Route("/blocks/{id}/images/delete", name="admin_page_block_image_delete")
     * @Method({"POST"})
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function deleteAction(int $id, Request $request): Response
    {
        $block = $this->blockManager->get($id);
        if (!$block) {
            return $this->redirectToRoute('admin_pages');
        }
        $image = $this->imageManager->get($request->request->get('id'), false);

        $token = $request->request->get('token');
        if ($this->isCsrfTokenValid('page-block-image-delete', $token)) {
            $this->imageManager->remove($image);
        }

        return $this->redirectToRoute('admin_page_block_images_manager', [
            'id' => $block->getId(),
        ]);
    }
}
