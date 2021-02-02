<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UsineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UsineRepository::class)
 */
class Usine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups("gift:read")
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Gift::class, mappedBy="usine", cascade={"persist", "remove"})
     */
    private $gift;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $this->gift->setUsine(null);
        }

        // set the owning side of the relation if necessary
        if ($gift !== null && $gift->getUsine() !== $this) {
            $gift->setUsine($this);
        }

        $this->gift = $gift;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }
}
