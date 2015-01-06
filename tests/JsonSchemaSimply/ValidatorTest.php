<?php

namespace JsonSchemaSimply\Tests;

use JsonSchemaSimply\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @see testValidationIntegerType
     * @return array
     */
    public function provideIntegerTypes()
    {
        return [
            [
                '{"id": 123}',
                '{"id": <integer>}',
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
     * @dataProvider provideIntegerTypes
     */
    public function testValidationIntegerType($data, $schema, $expectedResult)
    {
        $validator = new Validator();
        $validator->check($data, $schema);

        $this->assertEquals($validator->isValid(), $expectedResult);
    }

}