<?php

namespace App\Services;

/**
 * PaymentService
 * DT Brand's & Jai Hanuman Tex
 */
class PaymentService
{
    public function getAvailableMethods(): array
    {
        return [
            ['id' => 'razorpay_upi', 'name' => 'UPI Instant (GPay / PhonePe / Paytm)', 'type' => 'prepaid'],
            ['id' => 'razorpay_cards', 'name' => 'Credit / Debit Cards / Netbanking', 'type' => 'prepaid'],
            ['id' => 'bank_wire', 'name' => 'Direct B2B NEFT / RTGS Wire Transfer', 'type' => 'b2b'],
            ['id' => 'cod', 'name' => 'Cash on Delivery (Verified Pin Codes)', 'type' => 'cod']
        ];
    }
}
