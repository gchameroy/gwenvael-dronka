<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageInterface
{
    public function getId(): int;
    /**
     * @return string|UploadedFile|null
     */
    public function getPath();
    public static function getDirectory(): string;
}
