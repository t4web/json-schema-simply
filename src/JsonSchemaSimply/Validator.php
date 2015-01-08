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

        $baseSchema = [
            "type" => "object",
            "properties" => $this->buildProperties($simplySchema),
            "required" => $this->buildRequired($simplySchema)
        ];

        return parent::check(json_decode($data), $this->toObject($baseSchema), $path, $i);
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

    private function toObject($data) {
        if (is_array($data)) {
            return (object) array_map([$this, 'toObject'], $data);
        }

        return $data;
    }

}