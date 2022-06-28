<?php

namespace App\Entity\Concern;

use CFile;
use Closure;
use Exception;

trait DataFetchModifiable
{
    public static function intModification(): Closure
    {
        return function (string $value) {
            return (int)$value;
        };
    }

    public static function floatModification(): Closure
    {
        return function (string $value) {
            return (float)$value;
        };
    }

    public static function filePathModification(): Closure
    {
        return function (string $value): ?string {
            if (empty($value)) {
                return null;
            }

            return CFile::GetPath($value);
        };
    }

    /**
     * @param string[] $modifications
     * @throws Exception
     */
    public static function getModifications(array $modifications): Closure
    {
        $result = [];
        foreach ($modifications as $modification) {
            $modifier = implode([$modification, 'Modification']);

            /*if (!is_callable([new self(), $modifier])) {
                throw new \Exception('Modifier is not exists');
            }*/

            $result[] = self::$modifier();
        }

        return function () use ($result): array {
            return $result;
        };
    }
}
