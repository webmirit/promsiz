<?php

declare(strict_types=1);

namespace App\ValueResolver;

use App\Request\IValidatable;
use App\Validator\Exception\ValidatorException;
use Exception;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validation;

class ValidatedRequest implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if ($type = $argument->getType()) {
            return
                in_array(IValidatable::class, class_implements($type, true))
                && class_exists($type);
        }

        return false;
    }

    /**
     * @throws ValidatorException
     * @throws Exception
     */
    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $type = $argument->getType();
        $settableRequest = from_array_settable(
            new $type(),
            $request->request->all()
        );

        $validator = Validation::createValidatorBuilder()
            ->disableAnnotationMapping()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator()
        ;

        if (count($errors = $validator->validate($settableRequest))) {
            throw new ValidatorException($errors, 'validation.bad');
        }

        yield $settableRequest;
    }
}
