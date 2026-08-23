<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\DTOs\OrderDTO;

/**
 * OrderService
 * DT Brand's & Jai Hanuman Tex
 */
class OrderService
{
    private OrderRepository $orderRepo;

    public function __construct()
    {
        $this->orderRepo = new OrderRepository();
    }

    public function processCheckout(OrderDTO $dto): array
    {
        return $this->orderRepo->save([
            'customer_name' => $dto->customerName,
            'customer_phone' => $dto->customerPhone,
            'customer_email' => $dto->customerEmail,
            'channel' => $dto->channel,
            'items' => $dto->items,
            'discount' => $dto->discount,
            'shipping' => $dto->shipping,
            'gst_rate' => $dto->gstRate
        ]);
    }
}
