<?php

namespace App\Validators;

/**
 * CustomerValidator
 * DT Brand's & Jai Hanuman Tex
 */
class CustomerValidator
{
    public static function validate(array $data): array
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required.';
        }
        if (empty($data['phone'])) {
            $errors['phone'] = 'Phone number is required.';
        }
        return $errors;
    }
}
