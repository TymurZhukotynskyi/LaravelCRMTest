<?php

namespace App\Domain\Entities;

class Customer
{
    private int $id;
    private ?int $externalId;
    private string $firstName;
    private string $lastName;
    private ?string $username;
    private string $email;
    private ?int $age;
    private ?string $phone;
    private ?string $birthDate;

    public function __construct(
        int $id,
        ?int $externalId,
        string $firstName,
        string $lastName,
        ?string $username,
        string $email,
        ?int $age,
        ?string $phone,
        ?string $birthDate
    ) {
        $this->id = $id;
        $this->externalId = $externalId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->email = $email;
        $this->age = $age;
        $this->phone = $phone;
        $this->birthDate = $birthDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function update(
        string $firstName,
        string $lastName,
        ?string $username,
        string $email,
        ?int $age,
        ?string $phone,
        ?string $birthDate
    ): void {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->email = $email;
        $this->age = $age;
        $this->phone = $phone;
        $this->birthDate = $birthDate;

        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->firstName) || empty($this->lastName)) {
            throw new \InvalidArgumentException('First name and last name cannot be empty.');
        }

        if (empty($this->username)) {
            throw new \InvalidArgumentException('Username cannot be empty.');
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address.');
        }

        if ($this->age !== null && ($this->age < 0 || $this->age > 122)) {
            throw new \InvalidArgumentException('Age must be between 0 and 150.');
        }

        if ($this->phone !== null) {
            if (!preg_match('/^\+[0-9]{9,13}$/', $this->phone)) {
                throw new \InvalidArgumentException('Phone must start with "+" and contain 9 to 13 digits.');
            }
        }

        if ($this->birthDate !== null) {
            $birthDate = \DateTime::createFromFormat('Y-m-d', $this->birthDate);
            if (!$birthDate || $birthDate->format('Y-m-d') !== $this->birthDate) {
                throw new \InvalidArgumentException('Birth date must be a valid date in Y-m-d format.');
            }

            $today = new \DateTime();
            if ($birthDate > $today) {
                throw new \InvalidArgumentException('Birth date cannot be in the future.');
            }

            $calculatedAge = $today->diff($birthDate)->y;
            if ($this->age !== null && $this->age !== $calculatedAge) {
                throw new \InvalidArgumentException('Age does not match birth date.');
            }
        }
    }

    public static function createWithMinimalData(int $id, string $firstName, string $lastName, string $email): self
    {
        $customer = new self(
            $id,
            null, // externalId
            $firstName,
            $lastName,
            null,
            $email,
            null,
            null,
            null
        );
        $customer->validateMinimalData();
        return $customer;
    }

    private function validateMinimalData(): void
    {
        if (empty($this->firstName) || empty($this->lastName)) {
            throw new \InvalidArgumentException('First name and last name cannot be empty.');
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address.');
        }
    }
}
