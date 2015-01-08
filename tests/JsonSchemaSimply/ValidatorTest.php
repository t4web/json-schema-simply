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
                '{"id": <integer>}',
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

    public function testValidationBadType()
{
    $data = '{"id": 123}';
    $schema = '{"id": <xxinteger>}';

    $this->setExpectedException('UnexpectedValueException');

    $validator = new Validator();
    $validator->check($data, $schema);
}

}