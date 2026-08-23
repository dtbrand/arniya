<?php

namespace App\DTOs;

/**
 * CustomerDTO — Data Transfer Object for Customers & B2B Partners
 * DT Brand's & Jai Hanuman Tex
 */
class CustomerDTO
{
    public function __construct(
        public string $name,
        public string $phone,
        public string $email,
        public string $type = 'retail',
        public string $city = '',
        public string $state = '',
        public string $tier = 'Standard'
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string)($data['name'] ?? ''),
            phone: (string)($data['phone'] ?? ''),
            email: (string)($data['email'] ?? ''),
            type: (string)($data['type'] ?? 'retail'),
            city: (string)($data['city'] ?? ''),
            state: (string)($data['state'] ?? ''),
            tier: (string)($data['tier'] ?? 'Standard')
        );
    }
}
