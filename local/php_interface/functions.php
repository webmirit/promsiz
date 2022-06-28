<?php

use Symfony\Component\PropertyAccess\PropertyAccessor;

if (!function_exists('getIbIdByCode')) {
    function getIbIdByCode(string $code): ?string
    {
        return container()->get(App\Service\Iblock::class)->getIblockIdByCode($code);
    }
}

if (!function_exists('from_array_settable')) {
    /**
     * @param $instance
     * @param array $payload
     * @return object
     * @throws Exception
     */
    function from_array_settable($instance, array $payload)
    {
        $accessor = new PropertyAccessor();

        if (!is_object($instance)) {
            throw new Exception();
        }

        foreach ($payload as $key => $value) {
            if ($accessor->isWritable($instance, $key)) {
                $accessor->setValue($instance, $key, $value);
            }
        }

        return $instance;
    }
}

