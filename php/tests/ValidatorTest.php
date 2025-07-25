<?php

use PHPUnit\Framework\TestCase;
use App\Validator;

class ValidatorTest extends TestCase
{
    public function testSafeInput()
    {
        $this->assertFalse(Validator::isXSS('hello world'));
        $this->assertFalse(Validator::isSQLInjection('just a normal phrase'));
    }

    public function testXSSDetection()
    {
        $this->assertTrue(Validator::isXSS('<script>alert("xss")</script>'));
        $this->assertTrue(Validator::isXSS('<img src=x onerror=alert(1)>'));
        $this->assertTrue(Validator::isXSS('<svg/onload=alert(1)>'));
    }

    public function testSQLInjectionDetection()
    {
        $this->assertTrue(Validator::isSQLInjection("1' OR '1'='1"));
        $this->assertTrue(Validator::isSQLInjection("DROP TABLE users;"));
        $this->assertTrue(Validator::isSQLInjection("SELECT * FROM users --"));
        $this->assertTrue(Validator::isSQLInjection("admin' --"));
    }

    public function testFalsePositivesAreAvoided()
    {
        $this->assertFalse(Validator::isSQLInjection('unionized labor movement'));
        $this->assertFalse(Validator::isSQLInjection('selective attention span'));
    }
}
