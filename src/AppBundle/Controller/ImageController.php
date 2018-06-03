<?php

namespace AppBundle\Controller;

use AppBundle\Manager\PageBlockImageManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @Route("/")
 */
class ImageController Extends Controller
{
    /**
     * @Route("/images/pb-{id}", name="page_block_image", requirements={"id": "\d+"})
     * @Method({"GET"})
     * @param int $id
     * @param PageBlockImageManager $imageManager
     * @param KernelInterface $kernel
     * @return BinaryFileResponse
     */
    public function viewPageBlockImageAction(int $id, PageBlockImageManager $imageManager, KernelInterface $kernel): BinaryFileResponse
    {
        $image = $imageManager->get($id);

        $filePath = $kernel->getRootDir() . '/../uploads/page-block-image/';
        $file = $filePath . $image->getPath();

        return new BinaryFileResponse($file);
    }
}
