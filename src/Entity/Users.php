<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @ORM\Table(name="users")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please enter a firstName")
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @Assert\NotBlank(message="Please enter a lastName")
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $phoneNumbers;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Users
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Users
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getPhoneNumbers(): ?array
    {
        return is_null($this->phoneNumbers) ?
            $this->phoneNumbers :
            unserialize($this->phoneNumbers);
    }

    /**
     * @param string $phoneNumbers
     * @return Users
     */
    public function setPhoneNumbers(string $phoneNumbers): self
    {
        $this->phoneNumbers = $phoneNumbers;

        return $this;
    }
}
