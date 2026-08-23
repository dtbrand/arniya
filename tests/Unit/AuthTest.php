<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\Auth;

class AuthTest extends TestCase
{
    public function testRegisterValidation(): void
    {
        $res = Auth::register([
            'name' => '',
            'phone' => '',
            'password' => ''
        ]);
        $this->assertFalse($res['success']);
    }

    public function testRegisterShortPassword(): void
    {
        $res = Auth::register([
            'name' => 'Test User',
            'phone' => '9876543210',
            'password' => '123'
        ]);
        $this->assertFalse($res['success']);
        $this->assertStringContainsString('at least 6 characters', $res['message']);
    }

    public function testLoginValidation(): void
    {
        $res = Auth::login('', '');
        $this->assertFalse($res['success']);
    }

    public function testAdminLoginValidation(): void
    {
        $res = Auth::adminLogin('admin@dtbrand.com', 'Gautam@9006');
        $this->assertTrue($res['success']);
        $this->assertEquals('super_admin', $res['admin']['role']);
    }

    public function testLogoutClearsSession(): void
    {
        Auth::logout();
        $this->assertNull(Auth::getCurrentUser());
        $this->assertFalse(Auth::isLoggedIn());
    }
}
