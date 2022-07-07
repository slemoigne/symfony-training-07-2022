<?php

namespace App\MessageHandler;

use App\Entity\Movie;
use App\Event\ImportMovieEvent;
use App\Api\OmdbApiClient;
use App\Message\ImportMovieMessage;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ImportMovieMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        protected OmdbApiClient            $omdbApiClient,
        protected EntityManagerInterface   $entityManager,
        protected EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ImportMovieMessage $message)
    {
        $response = $this->omdbApiClient->getByTitle($message->getTitle());
        $movie = new Movie();
        $movie
            ->setDirector($response['Director'])
            ->setYear($response['Year'])
            ->setTitle($response['Title'])
            ->setRating($response['imdbRating'])
            ->setPoster($response['Poster']);

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new ImportMovieEvent('api', $movie));
    }
}
