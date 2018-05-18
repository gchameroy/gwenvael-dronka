<?php

namespace AppBundle\DependencyInjection\Mail;

use AppBundle\Entity\Message;

class MailContact extends BaseMail
{
    public function sendMessage(Message $message)
    {
        $html = $this->twig->render('website/contact/mail-send-message.html.twig', [
            'message' => $message
        ]);
        $mail = $this->createMail($message->getSubject(), $html);
        $this->mailer->send($mail);
    }
}
