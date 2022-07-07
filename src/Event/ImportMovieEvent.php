<?php

namespace App\Event;

use App\Entity\Movie;
use Symfony\Contracts\EventDispatcher\Event;

class ImportMovieEvent extends Event
{
    public function __construct(
        public string $source,
        public Movie $movie,
    ) {}
}
