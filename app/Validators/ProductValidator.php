<?php

namespace App\Validators;

/**
 * ProductValidator
 * DT Brand's & Jai Hanuman Tex
 */
class ProductValidator
{
    public static function validate(array $data): array
    {
        $errors = [];
        if (empty($data['title'])) {
            $errors['title'] = 'Product title is required.';
        }
        if (empty($data['mrp']) || (float)$data['mrp'] <= 0) {
            $errors['mrp'] = 'Valid MRP is required.';
        }
        return $errors;
    }
}
