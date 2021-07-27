<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity
 */
class Employee
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @OA\Property(type="string")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @OA\Property(type="string")
     * @Groups({"read", "save"})
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @OA\Property(type="string")
     * @Groups({"read", "save"})
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @OA\Property(
     *     type="string",
     *     enum={"help_desk", "manager", "customer_support", "director"}
     * )
     * @Groups({"read", "save"})
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @OA\Property(type="string")
     * @Groups({"read", "save"})
     */
    private $phoneNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }
}