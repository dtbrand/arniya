<?php

namespace App\Controllers;

use App\Services\OrderService;
use App\DTOs\OrderDTO;
use App\Validators\OrderValidator;
use App\Helpers\ResponseHelper;

/**
 * OrderController
 * DT Brand's & Jai Hanuman Tex
 */
class OrderController
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function store(): void
    {
        $data = $_POST;
        $errors = OrderValidator::validate($data);
        if (!empty($errors)) {
            ResponseHelper::error('Validation Failed', 422, $errors);
            return;
        }

        $dto = OrderDTO::fromArray($data);
        $order = $this->orderService->processCheckout($dto);
        ResponseHelper::success($order, 'Order placed successfully', 201);
    }
}
