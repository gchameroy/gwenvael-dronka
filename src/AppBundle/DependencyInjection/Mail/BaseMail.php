<?php

namespace AppBundle\DependencyInjection\Mail;

use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

abstract class BaseMail
{
    const TO = 'contact@une-methode-douce.fr';
    const FROM = 'noreply@une-methode-douce.fr';

    /** @var Swift_Mailer */
    protected $mailer;

    /** @var Twig_Environment */
    protected $twig;

    public function __construct(Swift_Mailer $mailer, Twig_Environment $twig )
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function createMail(string $subject, string $body, string $to = self::TO, string $from = self::FROM): Swift_Message
    {
        return (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/html');
    }
}
