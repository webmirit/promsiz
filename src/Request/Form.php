<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Form implements IValidatable
{
    protected $formId;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $notBlank = new Assert\NotBlank(['message' => 'This :field: was not expected.']);
        $required = new Assert\Required([
            $notBlank,
            new Assert\Type('int')
        ]);
        $metadata->addPropertyConstraint('formId', $required);
    }

    /**
     * @return mixed
     */
    public function getFormId(): ?int
    {
        return $this->formId;
    }

    /**
     * @param mixed $formId
     */
    public function setFormId(int $formId): self
    {
        $this->formId = $formId;

        return $this;
    }
}
