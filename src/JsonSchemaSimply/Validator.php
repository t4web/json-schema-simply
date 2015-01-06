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

        $simplySchema = json_decode(str_replace(array('<', '>'), '"', $schema), true);
die(var_dump(json_decode('{
                    "type": "object",
                    "properties": {
                        "id": {
                            "type": "integer"
                        }
                    },
                    "required": ["id"]
                }')));
        $baseSchema = [
            "type" => "object",
            "properties" => $this->buildProperties($simplySchema),
            "required" => $this->buildRequired($simplySchema)
        ];
die(var_dump((object)$baseSchema));
        return parent::check(json_decode($data), (object)$baseSchema, $path, $i);
    }

    private function buildProperties(array $schema)
    {
        $properties = [];

        foreach ($schema as $elementName => $elementType) {
            $properties[$elementName]['type'] = $elementType;
        }

        return $properties;
    }

    private function buildRequired(array $schema)
    {
        $required = [];

        foreach ($schema as $elementName => $elementType) {
            $required[] = $elementName;
        }

        return $required;
    }

    public function arrayToObject($d) {
        if (is_array($d)) {
            return (object) array_map(__FUNCTION__, $d);
        }
        else {
            return $d;
        }
    }

}