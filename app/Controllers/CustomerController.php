<?php

namespace App\Controllers;

use App\Repositories\CustomerRepository;
use App\Helpers\ResponseHelper;

/**
 * CustomerController
 * DT Brand's & Jai Hanuman Tex
 */
class CustomerController
{
    private CustomerRepository $customerRepo;

    public function __construct()
    {
        $this->customerRepo = new CustomerRepository();
    }

    public function index(): void
    {
        $type = $_GET['type'] ?? '';
        $customers = $type ? $this->customerRepo->getByType($type) : $this->customerRepo->getAll();
        ResponseHelper::success($customers);
    }
}
