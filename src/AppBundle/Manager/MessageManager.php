<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Message;
use AppBundle\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;

class MessageManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var MessageRepository */
    private $messageRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->messageRepository = $this->entityManager->getRepository(Message::class);
    }

    public function getNew(): Message
    {
        return new Message();
    }

    public function save(Message $message): Message
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $message;
    }
}
