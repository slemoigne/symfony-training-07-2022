<?php

namespace App\Message;

final class ImportMovieMessage
{
     public function __construct(
         protected string $title)
     {}

    public function getTitle(): string
    {
        return $this->title;
    }
}
