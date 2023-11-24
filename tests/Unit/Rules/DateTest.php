<?php

use App\Validation\Rules\DateRule;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function testDate_dmY()
    {
        $rule = new DateRule("d/m/Y");
        $rule->setValue("01/01/2000");

        $this->assertTrue($rule->isRuleValid());
    }

    public function testDate_Ymd()
    {
        $rule = new DateRule();
        $rule->setValue("2000/01/01");

        $this->assertTrue($rule->isRuleValid());
    }

    public function testDate_fail(){
        $rule = new DateRule();
        $rule->setValue("1900/02/29");

        $this->assertFalse($rule->isRuleValid());
    }
}
