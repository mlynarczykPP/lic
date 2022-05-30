<?php

/**
 * Baza controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BazaController.
 *
 * @Route("/baza")
 */
class BazaController extends AbstractController
{
    /**
     * Index action.
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="baza",
     * )
     */
    public function index(): Response
    {
        return $this->render(
            'baza.html.twig',
        );
    }
}
