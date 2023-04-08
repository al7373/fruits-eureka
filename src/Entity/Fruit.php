<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FruitRepository::class)
 */
class Fruit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"fruit:list"})
     */
    private $fruit_id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"fruit:list"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"fruit:list"})
     */
    private $family;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"fruit:list"})
     */
    private $genus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"fruit:list"})
     */
    private $fruit_order;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"fruit:list"})
     */
    private $carbohydrates;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"fruit:list"})
     */
    private $protein;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"fruit:list"})
     */
    private $fat;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"fruit:list"})
     */
    private $calories;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"fruit:list"})
     */
    private $sugar;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"fruit:list"})
     */
    private $isFavorite = false;

    public function getIsFavorite(): bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFruitId(): ?int
    {
        return $this->fruit_id;
    }

    public function setFruitId(int $fruit_id): self
    {
        $this->fruit_id = $fruit_id;

        return $this;
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

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(?string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(?string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    public function getFruitOrder(): ?string
    {
        return $this->fruit_order;
    }

    public function setFruitOrder(?string $fruit_order): self
    {
        $this->fruit_order = $fruit_order;

        return $this;
    }

    public function getCarbohydrates(): ?float
    {
        return $this->carbohydrates;
    }

    public function setCarbohydrates(?float $carbohydrates): self
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(?float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getFat(): ?float
    {
        return $this->fat;
    }

    public function setFat(float $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getCalories(): ?float
    {
        return $this->calories;
    }

    public function setCalories(?float $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getSugar(): ?float
    {
        return $this->sugar;
    }

    public function setSugar(?float $sugar): self
    {
        $this->sugar = $sugar;

        return $this;
    }
}
