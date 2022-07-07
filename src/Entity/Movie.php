<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $director;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity=MovieImportLog::class, mappedBy="movie", orphanRemoval=true)
     */
    private $movieImportLogs;

    public function __construct()
    {
        $this->movieImportLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, MovieImportLog>
     */
    public function getMovieImportLogs(): Collection
    {
        return $this->movieImportLogs;
    }

    public function addMovieImportLog(MovieImportLog $movieImportLog): self
    {
        if (!$this->movieImportLogs->contains($movieImportLog)) {
            $this->movieImportLogs[] = $movieImportLog;
            $movieImportLog->setMovie($this);
        }

        return $this;
    }

    public function removeMovieImportLog(MovieImportLog $movieImportLog): self
    {
        if ($this->movieImportLogs->removeElement($movieImportLog)) {
            // set the owning side to null (unless already changed)
            if ($movieImportLog->getMovie() === $this) {
                $movieImportLog->setMovie(null);
            }
        }

        return $this;
    }
}
