<?php

namespace JsonSchemaSimply;

use JsonSchema\Validator as BaseValidator;

class Validator extends BaseValidator
{

    public function check($data, $schema = null, $path = null, $i = null)
    {
        if (is_null($schema)) {
            throw new InvalidArgumentException('Schema must be not empty');
        }

        return parent::check($data, $schema, $path, $i);
    }

}