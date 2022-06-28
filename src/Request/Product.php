<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Product implements IValidatable
{
    protected $category;

    protected $formId = [];

    protected $techId = [];

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $notBlank = new Assert\NotBlank(['message' => 'This :field: was not expected.']);
        $intOrArray = new Assert\Type(['int', 'array']);
        $required = new Assert\Required([
            $notBlank,
            new Assert\Type(['int']),
            new Assert\NotEqualTo(0),
        ]);
        $metadata->addPropertyConstraint('category', $required);
        $metadata->addPropertyConstraint('formId', $intOrArray);
        $metadata->addPropertyConstraint('techId', $intOrArray);
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): Product
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return array|int
     */
    public function getFormId()
    {
        return $this->formId;
    }

    /**
     * @param mixed $formId
     */
    public function setFormId($formId): Product
    {
        $this->formId = $formId;

        return $this;
    }

    /**
     * @return array|int
     */
    public function getTechIds()
    {
        return $this->techId;
    }

    /**
     * @param mixed $techId
     */
    public function setTechId($techId): Product
    {
        $this->techId = $techId;

        return $this;
    }
}
