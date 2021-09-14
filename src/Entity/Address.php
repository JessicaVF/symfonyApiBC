<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 *
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"garageDisplay"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"garageDisplay", "adminGarageDisplay"})
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"garageDisplay", "adminGarageDisplay"})
     */
    private $complement;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"garageDisplay", "adminGarageDisplay"})
     */
    private $road;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"garageDisplay", "adminGarageDisplay"})
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"garageDisplay", "adminGarageDisplay"})
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity=Garage::class, mappedBy="address", cascade={"persist", "remove"})
     */
    private $garage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getRoad(): ?string
    {
        return $this->road;
    }

    public function setRoad(string $road): self
    {
        $this->road = $road;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getGarage(): ?Garage
    {
        return $this->garage;
    }

    public function setGarage(Garage $garage): self
    {
        // set the owning side of the relation if necessary
        if ($garage->getAddress() !== $this) {
            $garage->setAddress($this);
        }

        $this->garage = $garage;

        return $this;
    }
}
