<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\FreeItem;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class NewFreeItemNotifier
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function postPersist(FreeItem $freeItem, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // only act if a new post has been submitted
        if (!$entity instanceof FreeItem) {
            return;
        }

        $entityManager = $args->getObjectManager();

        $user = $freeItem->getUser();

        if($user)
        {
            
            $email = (new TemplatedEmail())
            ->from('info@32collect.djbagsofun.co.uk')
            ->to($user->getEmail())
            ->subject('Your new 32collect ad '.$freeItem->getTitle().' is now live')
            ->htmlTemplate('emails/new_32_collect_post_email.html.twig')
            ->context([
                'name' => $user->getName(),
                'freeItemTitle' => $freeItem->getTitle(),
                'totalFreeAds' => $user->getTotalFreeAds()
            ]);

            $this->mailer->send($email);

        } 

    }
}