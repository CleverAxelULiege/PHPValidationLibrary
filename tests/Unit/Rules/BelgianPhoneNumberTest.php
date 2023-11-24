<?php

use App\Validation\Rules\BelgianPhoneNumberRule;
use PHPUnit\Framework\TestCase;

class BelgianPhoneNumberTest extends TestCase
{
    public function test_phone_number_0032()
    {
        $rule = new BelgianPhoneNumberRule();
        $rule->setValue("0032 71 000000");
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_phone_number_plus_32()
    {
        $rule = new BelgianPhoneNumberRule();
        $rule->setValue("+32 4 000 00 00");
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_phone_number_noprefix()
    {
        $rule = new BelgianPhoneNumberRule();
        $rule->setValue("016 00 00 00");
        $this->assertTrue($rule->isRuleValid());
    }
}
