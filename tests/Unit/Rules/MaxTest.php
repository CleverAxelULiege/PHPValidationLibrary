<?php

use App\Validation\Rules\MaxRule;
use PHPUnit\Framework\TestCase;

class MaxTest extends TestCase
{
    public function test_valid()
    {
        $rule = new MaxRule(30);
        $rule->setValue(29.9);

        $this->assertTrue($rule->isRuleValid());
    }

    public function test_fail()
    {
        $rule = new MaxRule(30.2);
        $rule->setValue("30.3");

        $this->assertFalse($rule->isRuleValid());
    }
}
