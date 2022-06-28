<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class FormAndTech implements IValidatable
{
    protected $formId;

    protected $techId;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $numeric = new Assert\Type(['int', 'array']);

        $metadata->addPropertyConstraint('formId', $numeric);
        $metadata->addPropertyConstraint('techId', $numeric);
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
    public function setFormId($formId): self
    {
        $this->formId = $formId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTechId(): ?int
    {
        return $this->techId;
    }

    /**
     * @param mixed $techId
     */
    public function setTechId($techId): self
    {
        $this->techId = $techId;

        return $this;
    }
}
