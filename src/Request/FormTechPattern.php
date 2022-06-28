<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class FormTechPattern extends FormAndTech
{
    /**@var array */
    protected $pattern = [];

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $array = new Assert\Type(['array']);
        $metadata->addPropertyConstraint('pattern', $array);
        parent::loadValidatorMetadata($metadata);
    }

    /**
     * @return array
     */
    public function getPattern(): array
    {
        return $this->pattern;
    }

    /**
     * @param array $pattern
     * @return FormTechPattern
     */
    public function setPattern(array $pattern): FormTechPattern
    {
        $this->pattern = $pattern;

        return $this;
    }
}
