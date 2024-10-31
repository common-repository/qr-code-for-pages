<?php

namespace Me_Qr\Services\Packages\Validator\Assert;

use Me_Qr\Exceptions\InternalSystemException;
use Me_Qr\Services\Packages\Validator\Assert\Models\ValidatedClass;
use Me_Qr\Services\Packages\Validator\Assert\Models\ValidatedProperty;
use Me_Qr\Services\Packages\Validator\Assert\Models\ValidationType;
use ReflectionObject;

class AnnotationParser
{
    /**
     * @throws InternalSystemException
     */
    public function parse(object $object): array
    {
        $reflection = new ReflectionObject($object);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $annotations = $property->getDocComment();
            if (!$annotations || !strripos($annotations, AssertConfigs::ASSERT_ANNOTATION_TITLE)) {
                continue;
            }

            $property->setAccessible(true);
            $propertyArr[] = new ValidatedProperty(
                $property->getName(),
                $property->getValue($object),
                $this->parseAnnotations($annotations),
            );
        }

        return $propertyArr ?? [];
    }

    public function parseValidationClass(object $object): ValidatedClass
    {
        $reflection = new ReflectionObject($object);
        $classAnnotations = $reflection->getDocComment();
        $annotation = $this->processAnnotations($classAnnotations);
        preg_match('/@' . AssertConfigs::ASSERT_ANNOTATION_TITLE . '((.*)\)/', $annotation, $matches);
        $annotationOptionsStr = $matches[1] ?? null;

        $validatedClass = new ValidatedClass();
        if (!$annotationOptionsStr) {
            return $validatedClass;
        }
        $options = $this->parseOptions($annotationOptionsStr);
        $translateOption = ($options[AssertConfigs::ASSERT_TRANSLATE_CLASS_OPTION] ?? null) === 'true';
        $validatedClass->setTranslate($translateOption);

        return $validatedClass;
    }

    /**
     * @return ValidationType[]
     * @throws InternalSystemException
     */
    private function parseAnnotations(string $annotationsStr): array
    {
        $validationTypeArr = [];

        $annotationsStr = $this->processAnnotations($annotationsStr);
        preg_match_all(
            '/@' . AssertConfigs::ASSERT_ANNOTATION_TITLE . '\\([A-Za-z]+)\\s*\\(\\s*([^\\)]*)\\)/',
            $annotationsStr,
            $annotations,
            PREG_SET_ORDER
        );

        foreach ($annotations as $annotationMatch) {
            $annotationTitle = $this->processAnnotationTitle($annotationMatch[1] ?? null);
            if (!$annotationTitle) {
                throw new InternalSystemException('Annotation name parsing error. Title not found');
            }
            $annotationOptions = $this->parseOptions($annotationMatch[2] ?? '');

            foreach (AssertConfigs::getAssertTypes() as $validationTypeTitle => $namespace) {
                if ($validationTypeTitle === $annotationTitle) {
                    $validationTypeArr[] = new ValidationType($validationTypeTitle, $namespace, $annotationOptions);
                }
            }
        }

        return $validationTypeArr;
    }

    private function parseOptions(string $annotationOptionsStr): array
    {
        $parsedOptions = [];
        if (!$annotationOptionsStr) {
            return $parsedOptions;
        }
        preg_match_all(
            '/\s*([^=\s]*)\s*=\s*"([^"]+)"(?:,|$)?/',
            $annotationOptionsStr,
            $matches,
            PREG_SET_ORDER
        );

        foreach ($matches as $match) {
            $key = $match[1] ?? '';
            $value = $match[2] ?? '';
            $parsedOptions[$key] = $value;
        }

        return $parsedOptions;
    }

    private function processAnnotations(string $annotation): string
    {
        // Removes the characters '*', except for the escaped '\*'
        $annotation = preg_replace('/(?<!\\\\)\*/', '', $annotation);
        // Replacing the escaped character '\*' with the character '*'
        $annotation = str_replace('\\*', '*', $annotation);
        // Replacing multiple spaces with single spaces
        $annotation = preg_replace('/\s+/', ' ', $annotation);
        // Removing initial and ending spaces
        $annotation = trim($annotation);

        return $annotation;
    }

    private function processAnnotationTitle(string $title): ?string
    {
        $annotationTitle = str_replace(AssertConfigs::ASSERT_ANNOTATION_TITLE, '', $title);
        $annotationTitle = preg_replace('|\s+|', ' ', $annotationTitle);
        if (!$annotationTitle || !array_key_exists($annotationTitle, AssertConfigs::getAssertTypes())) {
            return null;
        }

        return $annotationTitle;
    }
}