<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\GiftRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"gift:read"}},
 *     denormalizationContext={"groups"={"gift:write"}}
 * )
 * @ORM\Entity(repositoryClass=GiftRepository::class)
 */
class Gift
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("gift:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups("gift:read")
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"gift:read", "gift:write"})
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     * 
     * @Groups({"gift:read", "gift:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups({"gift:read", "gift:write"})
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity=Receiver::class, inversedBy="gift", cascade={"persist", "remove"})
     * @ApiSubresource
     * 
     * @Groups({"gift:read", "gift:write"})
     */
    private $receiver;

    /**
     * @ORM\OneToOne(targetEntity=Usine::class, inversedBy="gift", cascade={"persist", "remove"})
     * @ApiSubresource
     * 
     * @Groups({"gift:read", "gift:write"})
     */
    private $usine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getReceiver(): ?Receiver
    {
        return $this->receiver;
    }

    public function setReceiver(?Receiver $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getUsine(): ?Usine
    {
        return $this->usine;
    }

    public function setUsine(?Usine $usine): self
    {
        $this->usine = $usine;

        return $this;
    }
}
