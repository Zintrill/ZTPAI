<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SnmpOverviewController extends AbstractController
{
    #[Route('/snmp/device/{id}', name: 'snmp_device_detail', requirements: ['id' => '\d+'])]
    public function showDevice(int $id): Response
    {
        return $this->render('snmp/device_detail.html.twig', [
            'deviceId' => $id
        ]);
    }
}
