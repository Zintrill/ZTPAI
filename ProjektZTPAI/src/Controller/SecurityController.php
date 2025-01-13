<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/register')]
class SecurityController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/', name: 'register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $user->setUsername('newuser');
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, 'password123')
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new Response('User registered successfully!');
    }
}
