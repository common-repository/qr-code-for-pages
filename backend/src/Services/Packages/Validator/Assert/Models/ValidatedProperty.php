<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Models;

class ValidatedProperty
{
    private string $propertyName;

    /**
     * @var mixed
     */
    private $propertyValue;

    /**
     * @var ValidationType[]
     */
    private array $validationTypes;

    /**
     * @param mixed $propertyValue
     * @param ValidationType[] $validationTypes
     */
    public function __construct(string $propertyName, $propertyValue, array $validationTypes)
    {
        $this->propertyName = $propertyName;
        $this->propertyValue = $propertyValue;
        $this->validationTypes = $validationTypes;
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @return mixed
     */
    public function getPropertyValue()
    {
        return $this->propertyValue;
    }

    /**
     * @return ValidationType[]
     */
    public function getValidationTypes(): array
    {
        return $this->validationTypes;
    }
}