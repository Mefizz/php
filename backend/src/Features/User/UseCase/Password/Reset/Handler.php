<?php

declare(strict_types=1);

namespace App\Features\User\UseCase\Password\Reset;

use App\Application\Service\Mail\EmailSender;
use App\Entity\Token\Reset\Fields\ExpireAt;
use App\Entity\Token\Reset\Fields\Token;
use App\Entity\Token\Reset\ResetToken;
use App\Features\User\Service\ResetTokenService;
use DateInterval;
use App\Features\User\Service\UserService;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Handler
{
    const SUBJECT = "Password Reset Request";

    public function __construct(
        private EmailSender         $emailSender,
        private TranslatorInterface $translator,
        private UserService         $userService,
        private ResetTokenService   $resetTokenService,
        private Environment         $twig
    )
    {
    }

    /**
     * @throws SyntaxError
     * @throws NonUniqueResultException
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function handle(Command $command): void
    {
        $user = $this->userService->get($command->email);

        $token    = Token::generate();
        $expireAt = ExpireAt::generate(new DateInterval('PT20M'));

        if (!$resetToken = $this->resetTokenService->findResetTokenByUser($user)) {
            $resetToken = new ResetToken(
                $token,
                $user,
                $expireAt
            );
        } else {
            $resetToken->changeToken($token, $expireAt);
        }

        $this->resetTokenService->save($resetToken);

        $this->emailSender->send(
            $user->getEmail()->getValue(),
            $this->translator->trans(self::SUBJECT),
            $this->twig->render('mail/user/reset_password.html.twig', [
                'code'   => $resetToken->getToken()->getValue(),
                'locale' => $user->getLocale()->getStringValue(),
            ])
        );
    }
}