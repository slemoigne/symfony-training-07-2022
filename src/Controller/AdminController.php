<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/movies", name="app_admin_index", methods={"GET"})
     */
    public function index(): Response
    {
        dd('coucou');
        return $this->render('main/index.html.twig');
    }
}
