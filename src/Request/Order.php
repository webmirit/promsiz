<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Order implements IValidatable
{
    protected $name;

    protected $phone;

    protected $basket = [];

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $notBlank = new Assert\NotBlank(['message' => 'This :field: was not expected.']);

        $metadata->addPropertyConstraint('name', $notBlank);
        $metadata->addPropertyConstraint('phone', $notBlank);


        $metadata->addPropertyConstraint(
            'basket',
            new Assert\All(
                new Assert\Collection([
                    'id' => new Assert\Required([
                        new Assert\NotBlank()
                    ]),
                    'quantity' => new Assert\Required([
                        new Assert\NotBlank()
                    ]),
                ])
            )
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): Order
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): Order
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return array
     */
    public function getBasket(): array
    {
        return $this->basket;
    }

    /**
     * @param mixed $basket
     */
    public function setBasket($basket): Order
    {
        $this->basket = $basket;

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
