<?php

use App\Validation\Rules\IntegerRule;
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{

    public function test_valid()
    {
        $rule = new IntegerRule();
        $rule->setValue("19");

        $this->assertTrue($rule->isRuleValid());
    }

    public function test_valid_negative()
    {
        $rule = new IntegerRule();
        $rule->setValue("-19");

        $this->assertTrue($rule->isRuleValid());
    }

    public function test_fail_float()
    {
        $rule = new IntegerRule();
        $rule->setValue(0.6);

        $this->assertFalse($rule->isRuleValid());
    }
    
    public function test_fail_float_string()
    {
        $rule = new IntegerRule();
        $rule->setValue("0.6");

        $this->assertFalse($rule->isRuleValid());
    }
}
