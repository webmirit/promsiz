<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

// FIXME: унифицировать, ради одного двух полей - треш
class Category implements IValidatable
{
    protected $category;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $notBlank = new Assert\NotBlank(['message' => 'This w was not expected.']);
        $required = new Assert\Required([
            $notBlank,
            new Assert\Type('int')
        ]);
        $metadata->addPropertyConstraint('category', $required);
    }

    /**
     * @return mixed
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory(int $category): self
    {
        $this->category = $category;

        return $this;
    }
}
