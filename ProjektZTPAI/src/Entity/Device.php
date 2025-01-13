<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $device_name = null;

    #[ORM\Column(length: 255)]
    private ?string $address_ip = null;

    #[ORM\ManyToOne(targetEntity: Type::class)]
    #[ORM\JoinColumn(name: "type_id", referencedColumnName: "type_id")]
    private ?Type $type = null;

    #[ORM\ManyToOne(targetEntity: SnmpVersion::class)]
    #[ORM\JoinColumn(name: "snmp_version_id", referencedColumnName: "snmp_version_id")]
    private ?SnmpVersion $snmp_version = null;
}
