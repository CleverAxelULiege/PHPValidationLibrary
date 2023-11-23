<?php

declare(strict_types=1);

use App\Helper\ValueHelper;
use App\Validation\Rules\BelgianPhoneNumberRule;
use App\Validation\Rules\LengthRule;
use App\Validation\Rules\MustBeAfterDateRule;
use App\Validation\Rules\MustBeBeforeDateRule;
use App\Validation\Rules\MustBeBeforeOrEqualsDateRule;
use App\Validation\Rules\NullableRule;
use App\Validation\Rules\RequiredIfRule;
use App\Validation\Rules\RequiredRule;
use App\Validation\Validator;
use PHPUnit\Framework\TestCase;

// ./vendor/bin/phpunit tests/Unit/ValidatorTest.php
final class ValidatorTest extends TestCase
{



    /**
     * Si une valeur associée à une clef est uniquement composée d'espace ou est vide ou est NULL ou simplement n'existe pas
     * ignore les autres règles si NullableRule est spécifiée.
     */
    public function test_NullableRule_white_space_string()
    {
        $data = [
            "username" => "       ",
            "password" => ""
        ];

        $rules = [
            "username" => [
                new NullableRule(), //Chaine de charactère uniquement composé d'espace vide les règles ne seront pas appliquées.
                new LengthRule(100, 3)
            ],
            "password" => [
                new NullableRule(), //Chaine de charactère vide les règles ne seront pas appliquées.
                new LengthRule(100, 8)
            ],
            "not_specified" => [
                new NullableRule(), //Aucune donnée n'a été envoyé avec cette clef, les règles ne seront pas appliquées.
                new BelgianPhoneNumberRule(),
            ]
        ];

        $this->assertTrue((new Validator($rules, $data))->validate());
    }



    /**
     * Si une valeur associée à une clef a le moindre input les règles seront appliquées même si NullableRule est spécifiée.
     */
    public function test_NullableRule_not_empty(){
        $data = [
            "username" => "b",
            "password" => null
        ];

        $rules = [
            "username" => [
                new NullableRule(),
                new LengthRule(100, 3), //Il y a input cette règle sera appliquée et ratera.
            ],
            "password" => [
                new NullableRule(),
                new LengthRule(100, 3), //NULL ne sera pas appliquée
            ],
        ];

        $this->assertFalse((new Validator($rules, $data))->validate());
    }



    /**
     * RequiredRule ainsi que NullableRule ne peuvent pas être dans le même array.
     * S'ils sont dans le même tableau une LogicException sera envoyé.
    */
    public function testException_RequiredRule_NullableRule(){
        $data = [
            "username" => "",
            "password" => ""
        ];

        $rules = [
            "username" => [
                new RequiredRule(),
                new NullableRule(),
                new LengthRule(100, 3)
            ],
            "password" => [
                new RequiredRule(),
                new NullableRule(),
                new LengthRule(100, 3),
            ],
        ];

        $this->expectException(LogicException::class); //exception pour les clefs "username" & "password"
        (new Validator($rules, $data))->validate();
    }



    /**
     * RequiredRule ainsi que RequiredIfRule ne peuvent pas être dans le même array.
     * S'ils sont dans le même tableau une LogicException sera envoyé.
    */
    public function testException_RequiredRule_RequiredIfRule(){
        $data = [
            "username" => "",
            "password" => ""
        ];

        $rules = [
            "username" => [
                new RequiredRule(),
                new LengthRule(100, 3)
            ],
            "password" => [
                new RequiredRule(),
                new RequiredIfRule("username", fn($username) => ValueHelper::isEmpty($username)),
                new LengthRule(100, 3),
            ],
        ];

        $this->expectException(LogicException::class); //exception pour la clef "password"
        (new Validator($rules, $data))->validate();
    }



    /**
     * Si la condition dans le RequiredIfRule a été remplie il ne doit pas ignorer les autres règles.
     */
    public function testException_RequiredIfRule_dont_ignore_other_rule_when_required(){
        $data = [
            "username" => "",
            "second_username" => "t"
        ];

        $rules = [
            "username" => [
                new NullableRule(),
                new LengthRule(100, 3)
            ],
            "second_username" => [
                new NullableRule(),
                new RequiredIfRule("username", fn($username) => ValueHelper::isEmpty($username)), //EST REQUIS => un input n'a pas été mis dans username
                new LengthRule(100, 3), //RequiredIf == TRUE => Applique les règles suivantes
            ],
        ];

        $this->assertFalse((new Validator($rules, $data))->validate());
    }

    /**
     * Si la condition dans le RequiredIfRule n'a pas été remplie il doit ignorer les autres règles.
     */
    public function testException_RequiredIfRule_ignore_other_rule_when_not_required(){
        $data = [
            "username" => "username_test",
            "second_username" => "t"
        ];

        $rules = [
            "username" => [
                new NullableRule(),
                new LengthRule(100, 3)
            ],
            "second_username" => [
                new NullableRule(),
                new RequiredIfRule("username", fn($username) => ValueHelper::isEmpty($username)), //N'EST PAS REQUIS => un input a été mis dans username
                new LengthRule(100, 3), //RequiredIf == FALSE => N'applique pas les règles suivantes même si elles sont enfreintes.
            ],
        ];

        $this->assertTrue((new Validator($rules, $data))->validate());
    }

    /**
     * Si la condition dans le RequiredIfRule n'a pas été remplie il ne doit quand même pas ignorer les autres règles car
     * shouldIgnoreOtherRulesIfNotRequired à FALSE.
     */
    public function testException_RequiredIfRule_dont_ignore_other_rule_when_not_required(){
        $data = [
            "username" => "username_test",
            "second_username" => "t"
        ];

        $rules = [
            "username" => [
                new NullableRule(),
                new LengthRule(100, 3)
            ],
            "second_username" => [
                new NullableRule(),
                //N'EST PAS REQUIS => un input a été mis dans username MAIS shouldIgnoreOtherRulesIfNotRequired mis à FALSE, respecte quand même les autres règles.
                new RequiredIfRule("username", fn($username) => ValueHelper::isEmpty($username), shouldIgnoreOtherRulesIfNotRequired:false), 
                new LengthRule(100, 3), //RequiredIf == FALSE => applique les règles suivantes car shouldIgnoreOtherRulesIfNotRequired == FALSE
            ],
        ];

        $this->assertFalse((new Validator($rules, $data))->validate());
    }
    

    
    /**
     * Comparaison de date entre une date hardcodée et entre deux inputs
     */
    public function testDate_comparaison(){  
        $data = [
            "start_date" => "2023/10/01",
            "end_date" => "2023/12/31"
        ];
    
        $rules = [
            "start_date" => [
                new RequiredRule(),
                new MustBeAfterDateRule("2023/09/01"), //doit commencer après le 2023/09/01
                new MustBeBeforeDateRule("end_date", isKey:true) //doit commencer avant la date dans end_date
            ],
            "end_date" => [
                new RequiredRule(),
                new MustBeBeforeOrEqualsDateRule("2023/12/31"), //doit commencer avant (ou au) 2023/12/31
                new MustBeAfterDateRule("start_date", isKey:true) //doit commencer après la date dans start_date
            ]
        ];
    
        $this->assertTrue((new Validator($rules, $data))->validate());
    }
    


    /**
     * Si un input est vide et que NullableRule est spécifié, la comparaison entre les valeurs
     * hardcodées et venant d'un autre input n'aura pas lieu.
     */
    public function testDate_comparaison_nullable(){  
        $data = [
            "start_date" => "2023/10/01",
        ];
    
        $rules = [
            "start_date" => [
                new NullableRule(),
                new MustBeAfterDateRule("2023/09/01"), //doit commencer après le 2023/09/01 => APPLIQUERA CETTE REGLE CAR NON VIDE
                new MustBeBeforeDateRule("end_date", isKey:true) //doit commencer avant la date dans end_date => N'APPLIQUERA PAS CETTE REGLE CAR END_DATE EST VIDE/NON PRÉCISÉ
            ],
            "end_date" => [
                new NullableRule(),
                new MustBeBeforeOrEqualsDateRule("2023/12/31"), //doit commencer avant (ou au) 2023/12/31 => N'APPLIQUERA PAS CETTE REGLE CAR END_DATE EST VIDE/NON PRÉCISÉ
                new MustBeAfterDateRule("start_date", isKey:true) //doit commencer après la date dans start_date => N'APPLIQUERA PAS CETTE REGLE CAR END_DATE EST VIDE/NON PRÉCISÉ
            ]
        ];
    
        $this->assertTrue((new Validator($rules, $data))->validate());
    }
}
