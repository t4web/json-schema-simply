<?php

namespace JsonSchemaSimply\Tests;

use JsonSchemaSimply\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @see testIndefiniteArticleForTypeInTypeCheckErrorMessage
     * @return array
     */
    public function provideIndefiniteArticlesForTypes()
    {
        return [
            [
                '{"id": 123}',
                '{
                    "type": "object",
                    "properties": {
                        "id": {
                            "type": "integer"
                        }
                    },
                    "required": ["id"]
                }',
                true
            ],
            [
                '{"id": "asd"}',
                '{
                    "type": "object",
                    "properties": {
                        "id": {
                            "type": "integer"
                        }
                    },
                    "required": ["id"]
                }',
                false
            ],
        ];
    }
    
    /**
     * @dataProvider provideIndefiniteArticlesForTypes
     */
    public function testValidationBaseTypes($data, $schema, $expectedResult)
    {
        $validator = new Validator();
        $validator->check(json_decode($data), json_decode($schema));

        $this->assertEquals($validator->isValid(), $expectedResult);
    }

}