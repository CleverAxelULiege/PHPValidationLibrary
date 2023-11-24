<?php

use App\Validation\Rules\InListRule;
use PHPUnit\Framework\TestCase;

class InListTest extends TestCase{

    public function test_valid(){
        $rule = new InListRule([1,2,3,4]);
        $rule->setValue(1);
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_fail(){
        $rule = new InListRule([1,2,3,4]);
        $rule->setValue(9);
        $this->assertFalse($rule->isRuleValid());
    }
}