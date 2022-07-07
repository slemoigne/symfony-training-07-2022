<?php

namespace App\Command;

use App\Api\OmdbApiClient;
use App\Entity\Movie;
use App\Event\ImportMovieEvent;
use App\Message\ImportMovieMessage;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'app:movie:new',
    description: 'Import a movie',
)]
class MovieNewCommand extends Command
{
    public function __construct(
        protected MessageBusInterface $messageBus,
        protected EntityManagerInterface $entityManager,
        string $name = null
    ){
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'Movie title')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $title = $input->getArgument('title');
        $this->messageBus->dispatch(new ImportMovieMessage($title));

        $repository = $this->entityManager->getRepository(Movie::class);
        $movies = $repository->findAll();
        $io->success('Movie to import: '. $title);

        $io->table(
            ['Title', 'Year', 'Poster'],
            array_map(
                static fn (Movie $movie) => [
                    $movie->getTitle(),
                    $movie->getYear(),
                    '<bg=blue;href='.$movie->getPoster().'>Poster link</>'
                ],
                $movies
            )
        );

        return 0;
    }
}
