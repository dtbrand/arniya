<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\Auth;
use DTBrand\Database;

/**
 * AuthTest — input validation only. Live credential checks are exercised
 * in the integration suite where a real database is available.
 */
class AuthTest extends TestCase
{
    public function testRegisterRejectsBlankFields(): void
    {
        $res = Auth::register([
            'name' => '',
            'phone' => '',
            'password' => '',
        ]);
        $this->assertFalse($res['success']);
    }

    public function testRegisterRejectsShortPassword(): void
    {
        $res = Auth::register([
            'name' => 'Test User',
            'phone' => '9876543210',
            'password' => '123',
        ]);
        $this->assertFalse($res['success']);
        $this->assertStringContainsStringIgnoringCase('at least 6', (string)($res['message'] ?? ''));
    }

    public function testLoginRejectsBlankFields(): void
    {
        $res = Auth::login('', '');
        $this->assertFalse($res['success']);
    }

    public function testLogoutClearsSession(): void
    {
        Auth::logout();
        $this->assertNull(Auth::getCurrentUser());
        $this->assertFalse(Auth::isLoggedIn());
    }
}