<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class SnmpVersion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $snmp_version_id = null;

    #[ORM\Column(length: 255)]
    private ?string $snmp = null;
}
