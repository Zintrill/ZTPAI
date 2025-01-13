<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users/{uuid}', name: 'user_profile', requirements: ['uuid' => '[0-9a-fA-F\-]{36}'])]
    public function showUser(string $uuid): Response
    {
        return $this->render('users/profile.html.twig', [
            'uuid' => $uuid,
        ]);
    }
}
