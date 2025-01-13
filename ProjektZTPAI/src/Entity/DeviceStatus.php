<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class DeviceStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Device::class)]
    #[ORM\JoinColumn(name: "device_id", referencedColumnName: "id")]
    private ?Device $device = null;

    #[ORM\Column(length: 255)]
    private ?string $mac_address = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;
}
