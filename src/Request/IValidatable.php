<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Mapping\ClassMetadata;

interface IValidatable
{
    /**
     * @param ClassMetadata $metadata
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void;
}
