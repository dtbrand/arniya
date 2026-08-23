<?php

namespace App\Validators;

/**
 * OrderValidator
 * DT Brand's & Jai Hanuman Tex
 */
class OrderValidator
{
    public static function validate(array $data): array
    {
        $errors = [];
        if (empty($data['items']) || !is_array($data['items'])) {
            $errors['items'] = 'Order must contain at least 1 item.';
        }
        if (empty($data['customer_name'])) {
            $errors['customer_name'] = 'Customer name is required.';
        }
        return $errors;
    }
}
