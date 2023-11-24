<?php

use App\Validation\Rules\LengthRule;
use PHPUnit\Framework\TestCase;

class LengthTest extends TestCase
{
    public function test_string_valid()
    {
        $rule = new LengthRule(100, 3);
        $rule->setValue("blabla");

        $this->assertTrue($rule->isRuleValid());
    }
    
    public function test_string_fail()
    {
        $rule = new LengthRule(100, 3);
        $rule->setValue("a");

        $this->assertFalse($rule->isRuleValid());
    }

    public function test_array_valid()
    {
        $rule = new LengthRule(100, 3);
        $rule->setValue([1,2,3]);

        $this->assertTrue($rule->isRuleValid());
    }

    public function test_array_fail()
    {
        $rule = new LengthRule(100, 3);
        $rule->setValue([]);

        $this->assertFalse($rule->isRuleValid());
    }

    public function test_not_string_not_array(){
        $rule = new LengthRule(100, 3);
        $rule->setValue(36);

        $this->assertFalse($rule->isRuleValid());
    }
}
