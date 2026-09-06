<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\PaymentManager;
use DTBrand\Database;

/**
 * PaymentManagerTest — Unit tests for the Multi-Gateway Payment Processing Engine.
 * Tests Direct UPI Deep Linking, NPCI URI generation, Razorpay HMAC verification,
 * Cashfree parameters, and secure storefront configuration masking.
 */
class PaymentManagerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Database::reset();
    }

    public function testGetAllGatewaysReturnsCompleteSuite(): void
    {
        $gateways = PaymentManager::getAllGateways(false);
        $this->assertIsArray($gateways);

        $expectedKeys = ['direct_upi', 'razorpay', 'cashfree', 'cod', 'whatsapp_pay'];
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $gateways, "Expected gateway key '{$key}' missing from suite.");
            $this->assertNotEmpty($gateways[$key]['name']);
            $this->assertIsArray($gateways[$key]['config']);
        }
    }

    public function testGetActiveGatewaysFiltersProperly(): void
    {
        $activeGateways = PaymentManager::getAllGateways(true);
        $this->assertIsArray($activeGateways);

        foreach ($activeGateways as $k => $g) {
            $this->assertTrue($g['is_active'], "Gateway '{$k}' in active list must have is_active true.");
        }
    }

    public function testGetSingleGatewayByKey(): void
    {
        $upi = PaymentManager::getGateway('direct_upi');
        $this->assertNotNull($upi);
        $this->assertEquals('direct_upi', $upi['gateway_key']);
        $this->assertArrayHasKey('upi_vpa', $upi['config']);

        $cod = PaymentManager::getGateway('cod');
        $this->assertNotNull($cod);
        $this->assertEquals('cod', $cod['gateway_key']);

        $nonExistent = PaymentManager::getGateway('non_existent_gateway_xyz');
        $this->assertNull($nonExistent);
    }

    public function testGetPublicConfigMasksSecrets(): void
    {
        $public = PaymentManager::getPublicConfig();
        $this->assertIsArray($public);

        foreach ($public as $key => $data) {
            $this->assertArrayHasKey('gateway_key', $data);
            $this->assertArrayHasKey('config', $data);

            $cfg = $data['config'];
            // Secrets must never be exposed to public frontend
            $this->assertArrayNotHasKey('key_secret', $cfg, "Secret key leaked in public config for '{$key}'");
            $this->assertArrayNotHasKey('secret_key', $cfg, "Secret key leaked in public config for '{$key}'");
            $this->assertArrayNotHasKey('api_secret', $cfg, "API secret leaked in public config for '{$key}'");
            $this->assertArrayNotHasKey('password', $cfg, "Password leaked in public config for '{$key}'");
        }
    }

    public function testGenerateUpiPayloadStructure(): void
    {
        $orderNo = 'ORD-2026-TEST-99';
        $amount = 2499.50;
        $customerName = 'Boutique Buyer';

        $payload = PaymentManager::generateUpiPayload($orderNo, $amount, $customerName);

        $this->assertEquals($orderNo, $payload['order_number']);
        $this->assertEquals($amount, $payload['amount']);
        $this->assertStringContainsString('₹', $payload['amount_fmt']);
        $this->assertNotEmpty($payload['upi_vpa']);
        $this->assertNotEmpty($payload['payee_name']);

        // Verify NPCI UPI URI Specification
        $upiUri = $payload['upi_uri'];
        $this->assertStringStartsWith('upi://pay?', $upiUri);
        $this->assertStringContainsString('cu=INR', $upiUri);
        $this->assertStringContainsString('am=2499.50', $upiUri);
        $this->assertStringContainsString('tr=' . $orderNo, $upiUri);

        // Verify native mobile app deep links
        $appLinks = $payload['app_links'];
        $this->assertIsArray($appLinks);
        $this->assertArrayHasKey('gpay', $appLinks);
        $this->assertArrayHasKey('phonepe', $appLinks);
        $this->assertArrayHasKey('paytm', $appLinks);
        $this->assertArrayHasKey('cred', $appLinks);
        $this->assertArrayHasKey('bhim', $appLinks);

        $this->assertStringStartsWith('gpay://', $appLinks['gpay']);
        $this->assertStringStartsWith('phonepe://', $appLinks['phonepe']);
        $this->assertStringStartsWith('paytmmp://', $appLinks['paytm']);
        $this->assertStringStartsWith('cred://', $appLinks['cred']);
        $this->assertStringStartsWith('bhim://', $appLinks['bhim']);
    }

    public function testVerifyRazorpaySignature(): void
    {
        // When secret is not configured / empty, verification must fail safely
        $orderId = 'order_DA1234567890';
        $paymentId = 'pay_DA0987654321';
        $fakeSig = 'fake_signature_hex_digest';

        $result = PaymentManager::verifyRazorpaySignature($orderId, $paymentId, $fakeSig);
        $this->assertFalse($result);
    }

    public function testCodConfigurationDefaults(): void
    {
        $cod = PaymentManager::getGateway('cod');
        $this->assertNotNull($cod);
        $cfg = $cod['config'] ?? [];

        $this->assertArrayHasKey('min_order', $cfg);
        $this->assertArrayHasKey('max_order', $cfg);
        $this->assertGreaterThan(0, (float)$cfg['min_order']);
        $this->assertGreaterThan((float)$cfg['min_order'], (float)$cfg['max_order']);
    }

    public function testWhatsAppPayConfigurationDefaults(): void
    {
        $waPay = PaymentManager::getGateway('whatsapp_pay');
        $this->assertNotNull($waPay);
        $cfg = $waPay['config'] ?? [];

        $this->assertArrayHasKey('phone', $cfg);
        $this->assertEquals('917046363528', $cfg['phone']);
    }
}
