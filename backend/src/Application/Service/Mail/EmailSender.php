<?php
declare(strict_types=1);

namespace App\Application\Service\Mail;

use Symfony\Component\Mailer\{Exception\TransportExceptionInterface, MailerInterface};
use Symfony\Component\Mime\Email;

class EmailSender
{
    public function __construct(
        private MailerInterface $mailer,
        private string          $from,
    )
    {
    }

    public function send(string $email, string $subject, string $textHtml): void
    {
        $email = (new Email())
            ->to($email)
            ->from($this->from)
            ->subject($subject)
            ->html($textHtml);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface) {
            throw new \DomainException('Unable to send message');
        }
    }
}