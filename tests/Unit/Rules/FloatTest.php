<?php

use App\Validation\Rules\FloatRule;
use PHPUnit\Framework\TestCase;

class FloatTest extends TestCase{

    public function test_valid(){
        $rule = new FloatRule();
        $rule->setValue(15.36);
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_valid_negative(){
        $rule = new FloatRule();
        $rule->setValue("-15.36");
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_valid_int(){
        $rule = new FloatRule();
        $rule->setValue("15");
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_valid_dot(){
        $rule = new FloatRule();
        $rule->setValue(".15");
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_valid_dot_negative(){
        $rule = new FloatRule();
        $rule->setValue(-.15);
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_not_valid(){
        $rule = new FloatRule();
        $rule->setValue("TARTE AU POMME");
        $this->assertFalse($rule->isRuleValid());
    }
}