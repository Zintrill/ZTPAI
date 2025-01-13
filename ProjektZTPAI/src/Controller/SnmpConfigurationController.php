<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SnmpConfigurationController extends AbstractController
{
    #[Route('/snmp/configuration', name: 'snmp_configuration')]
    public function index(): Response
    {
        return $this->render('snmp/configuration.html.twig');
    }
}
