<?php

namespace App\Repository;

use Bitrix\Main\ORM\Data\DataManager;
use InvalidArgumentException;
use Throwable;

abstract class BaseEntityRepository
{
    protected $entity = '';

    /**
     * @var DataManager
     */
    protected $entityObj;

    public function __construct()
    {
        try {
            $this->init();
        } catch (Throwable $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    private function init()
    {
        if (empty($this->entity)) {
            throw new InvalidArgumentException('Entity class path is empty.');
        }

        $this->entityObj = new $this->entity();
    }

    public function getEntity(): DataManager
    {
        return $this->entityObj;
    }
}
