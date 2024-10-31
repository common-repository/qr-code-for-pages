<?php

namespace Me_Qr\Services\Packages\Validator\Assert;

use Me_Qr\Core\Container;
use Me_Qr\Exceptions\ContainerException;
use Me_Qr\Services\Loggers\PluginCriticalErrorLogger;
use Me_Qr\Services\Packages\Validator\Assert\Constraints\AbstractConstraint;
use Me_Qr\Services\Packages\Validator\Assert\Models\ValidatedClass;
use Me_Qr\Services\Packages\Validator\Assert\Models\ValidatedProperty;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationExceptionInterface;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationSystemError;
use Me_Qr\Services\Packages\Validator\ValidationExceptionList;
use ReflectionException;
use Throwable;

class AssertService
{
    private AnnotationParser $annotationParser;
    private Container $container;

    public function __construct(
        AnnotationParser $annotationParser,
        Container $container
    ) {
        $this->annotationParser = $annotationParser;
        $this->container = $container;
    }

    public function validate($object): ValidationExceptionList
    {
		$exceptionList = new ValidationExceptionList();

        try {
            $validatedClass = $this->annotationParser->parseValidationClass($object);
            $validatedProps = $this->annotationParser->parse($object);
            if (empty($validatedProps)) {
                return $exceptionList;
            }
            foreach ($validatedProps as $prop) {
                $this->initializeValidationModules($exceptionList, $validatedClass, $prop);
            }

        } catch (Throwable $e) {
            PluginCriticalErrorLogger::logCoreException($e);
	        $exceptionList->addException(new ValidationSystemError());
        }

        return $exceptionList;
    }

    /**
     * @throws ContainerException
     * @throws ReflectionException
     * @throws ValidationExceptionInterface
     */
    private function initializeValidationModules(
	    ValidationExceptionList $exceptionList,
        ValidatedClass $validatedClass,
        ValidatedProperty $validatedProp
    ): void {
        foreach ($validatedProp->getValidationTypes() as $validationType) {
            /** @var AbstractConstraint $moduleClass */
            $moduleClass = $this->container->get($validationType->getNamespace());
            $validationException = $moduleClass->handel(
                $validatedClass,
                $validatedProp->getPropertyName(),
                $validatedProp->getPropertyValue(),
                $validationType->getOptions(),
            );
            if ($validationException) {
	            $exceptionList->addException($validationException);
            }
        }
    }
}
