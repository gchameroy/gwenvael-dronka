<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait ImageTrait
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string|UploadedFile|null $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string|UploadedFile|null
     */
    public function getPath()
    {
        return $this->path;
    }

    public static function getDirectory(): string
    {
        return __DIR__ . '/../../../uploads/image';
    }
}
