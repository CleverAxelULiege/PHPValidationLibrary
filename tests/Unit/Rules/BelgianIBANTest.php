<?php

use App\Validation\Rules\BelgianIBANRule;
use PHPUnit\Framework\TestCase;

//./vendor/bin/phpunit tests/Unit/Rules
class BelgianIBANTest extends TestCase
{
    public function testValid()
    {
        $rule = new BelgianIBANRule();
        $rule->setValue("BE67 1451 1251 1678");
        $this->assertTrue($rule->isRuleValid());
    }

    public function testNotValid_BE_lowercase(){
        $rule = new BelgianIBANRule();
        $rule->setValue("be67 1451 1251 1678");
        $this->assertFalse($rule->isRuleValid());
    }

    public function testNotValid_not_enough_numbers(){
        $rule = new BelgianIBANRule();
        $rule->setValue("BE67 1451 125 1678");
        $this->assertFalse($rule->isRuleValid());
    }
}
