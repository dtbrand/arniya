<?php

namespace App\DTOs;

/**
 * OrderDTO — Data Transfer Object for Orders
 * DT Brand's & Jai Hanuman Tex
 */
class OrderDTO
{
    public function __construct(
        public string $customerName,
        public string $customerPhone,
        public string $customerEmail,
        public string $channel,
        public array $items,
        public float $discount = 0.0,
        public float $shipping = 0.0,
        public float $gstRate = 5.0
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            customerName: (string)($data['customer_name'] ?? 'Valued Customer'),
            customerPhone: (string)($data['customer_phone'] ?? ''),
            customerEmail: (string)($data['customer_email'] ?? ''),
            channel: (string)($data['channel'] ?? 'retail'),
            items: (array)($data['items'] ?? []),
            discount: (float)($data['discount'] ?? 0.0),
            shipping: (float)($data['shipping'] ?? 0.0),
            gstRate: (float)($data['gst_rate'] ?? 5.0)
        );
    }
}
