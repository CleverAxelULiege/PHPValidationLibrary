<?php

use App\Validation\Rules\EmailRule;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{

    public function test_valid()
    {
        $rule = new EmailRule();
        $rule->setValue("test@mail.be");
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_valid_2()
    {
        $rule = new EmailRule();
        $rule->setValue("test@mail.org.test");
        $this->assertTrue($rule->isRuleValid());
    }

    public function test_fail(){
        $rule = new EmailRule();
        $rule->setValue("testmail.org");
        $this->assertFalse($rule->isRuleValid());
    }
}
