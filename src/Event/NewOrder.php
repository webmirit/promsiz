<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class NewOrder extends Event
{
    public const EVENT_NAME = 'CONFIGURATOR_ORDER';

    public const EVENT_CHANNEL_MAIL = 'EVENT_TYPE_MAIL';

    /**
     * @var array
     */
    private $data;

    /** @var string|null */
    private $type;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function mail(): self
    {
        $this->type = static::EVENT_CHANNEL_MAIL;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
