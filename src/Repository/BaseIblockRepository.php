<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\Iblock;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\SystemException;
use CIBlockElement;
use Exception;
use InvalidArgumentException;
use ReflectionException;
use Throwable;
use WebArch\BitrixCache\BitrixCache;

abstract class BaseIblockRepository
{
    /**
     * @var string|null
     */
    protected $ibCode;

    /**
     * @var null|int
     */
    protected $ibId;

    private $iblockService;

    public function __construct(string $ibCode, Iblock $iblock)
    {
        $this->ibCode = $ibCode;
        $this->iblockService = $iblock;

        try {
            $this->init();
        } catch (Throwable $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @throws LoaderException
     * @throws SystemException
     */
    private function init(): void
    {
        Loader::includeModule('iblock');

        if (!empty($this->ibCode) && !$this->ibId = $this->iblockService->getIblockIdByCode($this->ibCode)) {
            throw new InvalidArgumentException('Not found Iblock');
        }
    }

    public function getIblockId(): int
    {
        return $this->ibId;
    }

    /**
     * @throws Exception
     */
    public function add(array $data): int
    {
        $element = new CIBlockElement();

        if ($id = $element->Add($data)) {
            return $id;
        }

        throw new Exception($element->LAST_ERROR);
    }

    /**
     * @throws SystemException|ReflectionException
     */
    protected function cache(callable $callable, string $key, int $ttl = 84600, array $tags = [], string $subDir = ''): array
    {
        $result = (new BitrixCache())
            ->setId($key)
            ->setPath(implode(['/', $this->ibCode, !$subDir ?: '/' . $subDir]))
            ->setTime($ttl)
            ->setIblockTag($this->getIblockTag())
            ->callback($callable);

        return $result ?: [];
    }

    protected function getIblockTag(): string
    {
        return sprintf('iblock_%s_%s', $this->ibCode, $this->ibId);
    }
}
