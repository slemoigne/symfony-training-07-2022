<?php

namespace App\Controller;

use App\Api\OmdbApiClient;
use App\Entity\Movie;
use App\Event\ImportMovieEvent;
use App\Message\ImportMovieMessage;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/contact", name="app_main_contact", methods={"GET"})
     */
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig');
    }

    /**
     * @Route("/movie/login", name="app_main_login", methods={"GET"})
     */
    public function login(): Response
    {
        return $this->render('main/login.html.twig');
    }

    /**
     * @Route("/register", name="app_main_register", methods={"GET"})
     */
    public function register(): Response
    {
        return $this->render('main/register.html.twig');
    }

    /**
     * @Route("/password-recovering", name="app_main_password_recovering", methods={"GET"})
     */
    public function passwordRecovering(): Response
    {
        return $this->render('main/password_recovering.html.twig');
    }

    /**
     * @Route("/trailer-player", name="app_main_trailer_player", methods={"GET"})
     */
    public function trailerPlayer(): Response
    {
        return $this->render('main/trailer_player.html.twig');
    }

    /**
     * @Route("/import/{title}", name="app_fetch", methods={"GET"})
     */
    public function import(string $title, MessageBusInterface $messageBus): Response
    {
        $messageBus->dispatch(new ImportMovieMessage($title));
        return new Response('ok');
    }

    /*public function import(string $title, OmdbApiClient $omdbApiClient, EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher): Response
    {
        $response = $omdbApiClient->getByTitle($title);
        $movie = new Movie();
        $movie
            ->setDirector($response['Director'])
            ->setYear($response['Year'])
            ->setTitle($response['Title'])
            ->setRating($response['imdbRating'])
            ->setPoster($response['Poster'])
        ;

        $entityManager->persist($movie);
        $entityManager->flush();

        $eventDispatcher->dispatch(new ImportMovieEvent('api', $movie));

        return new Response('ok');
    }*/
}
