<?php

use App\Validation\Rules\MinRule;
use PHPUnit\Framework\TestCase;

class MinTest extends TestCase
{
    public function test_valid()
    {
        $rule = new MinRule(0);
        $rule->setValue("0.1");

        $this->assertTrue($rule->isRuleValid());
    }

    public function test_fail()
    {
        $rule = new MinRule(10);
        $rule->setValue("-0.9");

        $this->assertFalse($rule->isRuleValid());
    }
}
