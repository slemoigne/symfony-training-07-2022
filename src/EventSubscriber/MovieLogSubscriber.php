<?php

namespace App\EventSubscriber;

use App\Entity\MovieImportLog;
use App\Event\ImportMovieEvent;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Component\Mime\Email;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class MovieLogSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected MessageBusInterface $messageBus
    ) {}

    public function onImportMovieEvent(ImportMovieEvent $event): void
    {
        $log = new MovieImportLog();
        $log
            ->setDate(new \DateTime())
            ->setMovie($event->movie)
            ->setSource($event->source)
        ;

        $this->entityManager->persist($log);
        $this->entityManager->flush();

        $email = (new Email())
            ->from('from@training.com')
            ->to('to@training.com')
            ->subject('Import movie ' . $event->movie->getTitle())
            ->text('training test');

        $this->messageBus->dispatch(new SendEmailMessage($email));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ImportMovieEvent::class => 'onImportMovieEvent',
        ];
    }
}
