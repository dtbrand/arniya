<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\CurrencyHelper;
use App\Helpers\StringHelper;
use App\Services\PricingService;
use App\Services\ProductService;
use App\Services\PaymentService;
use App\Services\ShippingService;
use App\DTOs\OrderDTO;
use App\Validators\OrderValidator;
use Database\Seeders\DatabaseSeeder;

class AppArchitectureTest extends TestCase
{
    public function testCurrencyHelperFormatting(): void
    {
        $formatted = CurrencyHelper::format(5499.00);
        $this->assertEquals('₹5,499.00', $formatted);

        $parsed = CurrencyHelper::parse('₹5,499.00');
        $this->assertEquals(5499.00, $parsed);
    }

    public function testStringHelperSlugify(): void
    {
        $slug = StringHelper::slugify('Royal Heritage Kanjivaram Pure Silk');
        $this->assertEquals('royal-heritage-kanjivaram-pure-silk', $slug);
    }

    public function testProductServiceCatalog(): void
    {
        $service = new ProductService();
        $catalog = $service->getCatalog();
        $this->assertIsArray($catalog);
        $this->assertNotEmpty($catalog);
    }

    public function testPaymentServiceMethods(): void
    {
        $payment = new PaymentService();
        $methods = $payment->getAvailableMethods();
        $this->assertCount(4, $methods);
    }

    public function testShippingServiceThreshold(): void
    {
        $shipping = new ShippingService();
        $this->assertEquals(0.0, $shipping->calculateShippingFee(2500.00));
        $this->assertEquals(150.00, $shipping->calculateShippingFee(999.00));
    }

    public function testOrderValidatorValidation(): void
    {
        $errors = OrderValidator::validate(['items' => []]);
        $this->assertArrayHasKey('items', $errors);
        $this->assertArrayHasKey('customer_name', $errors);

        $cleanErrors = OrderValidator::validate([
            'items' => [['price' => 1000, 'quantity' => 1]],
            'customer_name' => 'Suresh'
        ]);
        $this->assertEmpty($cleanErrors);
    }

    public function testDatabaseSeeder(): void
    {
        $result = DatabaseSeeder::run();
        $this->assertEquals('success', $result['status']);
        $this->assertEquals(6, $result['seeded_categories']);
    }
}
