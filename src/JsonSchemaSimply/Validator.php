<?php

namespace JsonSchemaSimply;

use JsonSchema\Validator as BaseValidator;
use UnexpectedValueException;

class Validator extends BaseValidator
{
    private $typeNamespaces = ['JsonSchemaSimply\Type'];

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

    /**
     * @param array $schema
     * @return array
     */
    private function buildProperties(array $schema)
    {
        $properties = [];

        foreach ($schema as $elementName => $elementType) {

            if (!$this->typeExists($elementType)) {
                throw new UnexpectedValueException("Unknown type for <$elementType>");
            }

            $properties[$elementName]['type'] = $elementType;
        }

        return $properties;
    }

    /**
     * @param array $schema
     * @return array
     */
    private function buildRequired(array $schema)
    {
        $required = [];

        foreach ($schema as $elementName => $elementType) {
            $required[] = $elementName;
        }

        return $required;
    }

    private function toObject($data)
    {
        if (is_array($data)) {
            return (object) array_map([$this, 'toObject'], $data);
        }

        return $data;
    }

    private function typeExists($typeName)
    {
        foreach($this->typeNamespaces as $namespace) {
            $typeClass = trim($namespace, '\\') . '\\' . ucfirst($typeName);
            if (class_exists($typeClass)) {
                return true;
            }
        }

        return false;
    }

}