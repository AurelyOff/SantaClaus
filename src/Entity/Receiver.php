<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ReceiverRepository;


/**
 * @ApiResource(
 *     normalizationContext={"groups"={"receiver:read"}},
 *     denormalizationContext={"groups"={"receiver:write"}}
 * )
 * @ORM\Entity(repositoryClass=ReceiverRepository::class)
 */
class Receiver
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("receiver:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"receiver:read", "receiver:write", "gift:read"})
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"receiver:read", "receiver:write", "gift:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"receiver:read", "receiver:write", "gift:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=4)
     * 
     * @Groups({"receiver:read", "receiver:write", "gift:read"})
     */
    private $country;

    /**
     * @ORM\OneToOne(targetEntity=Gift::class, mappedBy="receiver", cascade={"persist", "remove"})
     * 
     * @Groups("receiver:read")
     */
    private $gift;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getGift(): ?Gift
    {
        return $this->gift;
    }

    public function setGift(?Gift $gift): self
    {
        // unset the owning side of the relation if necessary
        if ($gift === null && $this->gift !== null) {
            $this->gift->setReceiver(null);
        }

        // set the owning side of the relation if necessary
        if ($gift !== null && $gift->getReceiver() !== $this) {
            $gift->setReceiver($this);
        }

        $this->gift = $gift;

        return $this;
    }
}
