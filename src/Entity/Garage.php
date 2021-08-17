<?php

namespace App\Entity;

use App\Repository\GarageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=GarageRepository::class)
 * @ApiResource()
 */
class Garage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * * @Groups({"userDisplay"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"garageDisplay", "userDisplay"})
     */
    private $name;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"garageDisplay"})
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="garages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"garageDisplay"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="garage", orphanRemoval=true)
     * @Groups({"garageDisplay"})
     */
    private $annonces;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="garage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setGarage($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getGarage() === $this) {
                $annonce->setGarage(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
