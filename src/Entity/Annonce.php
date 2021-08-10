<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"annonceDisplay"})
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     * @Groups({"annonceDisplay"})
     */
    private $photos = [];

    /**
     * @ORM\Column(type="string", length=255)
     *@Groups({"annonceDisplay"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"annonceDisplay"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"annonceDisplay"})
     */
    private $circulationYear;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"annonceDisplay"})
     */
    private $kilometers;

    /**
     * @ORM\ManyToOne(targetEntity=Make::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"annonceDisplay"})
     */
    private $make;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"annonceDisplay"})
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"annonceDisplay"})
     */
    private $fuelType;

    /**
     * @ORM\ManyToOne(targetEntity=Garage::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $garage;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"annonceDisplay"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"annonceDisplay"})
     */
    private $shortDescription;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotos(): ?array
    {
        return $this->photos;
    }

    public function setPhotos(array $photos): self
    {
        $this->photos = $photos;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getCirculationYear(): ?int
    {
        return $this->circulationYear;
    }

    public function setCirculationYear(int $circulationYear): self
    {
        $this->circulationYear = $circulationYear;

        return $this;
    }

    public function getKilometers(): ?int
    {
        return $this->kilometers;
    }

    public function setKilometers(int $kilometers): self
    {
        $this->kilometers = $kilometers;

        return $this;
    }

    public function getMake(): ?Make
    {
        return $this->make;
    }

    public function setMake(Make $make): self
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(string $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getGarage(): ?Garage
    {
        return $this->garage;
    }

    public function setGarage(?Garage $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }
}
