<?php


namespace App\Service;


use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class ConfirmationEmailSender
{
    private MailerInterface $mailer;
    private RouterInterface $router;

    public function __construct(MailerInterface $mailer, RouterInterface $router) {

        $this->mailer = $mailer;
        $this->router = $router;
    }


    public function send(User $user): void {

        $confirmationLink = $this->router->generate("check_confirmation_link", [
            'token' => $user->getConfirmationToken(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);


        $confirmationEmail = (new TemplatedEmail())
            ->from("hello@world.dk")
            ->to($user->getEmail())
            ->subject('Confirm your account')
            ->htmlTemplate('emails/registration_confirmation.html.twig')
            ->context([
                'confirmationLink' => $confirmationLink
            ]);

            $this->mailer->send($confirmationEmail);
    }
}