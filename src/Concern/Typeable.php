<?php

namespace App\Concern;

trait Typeable
{
    protected function typify(array $data): array
    {
        $this->walkRecursive($data, function (&$item) {
            switch (true) {
                case is_numeric($item):
                    settype($item, 'integer');
                    return;
                case is_bool($item):
                    settype($item, 'boolean');
                    return;
            }
        });

        return $data;
    }

    private function walkRecursive(array &$data, callable $callback): void
    {
        foreach ($data as $key => &$value) {
            if (is_array($value)) {
                $this->walkRecursive($value, $callback);
                return;
            }

            $callback($value, $key, $callback);
        }
        unset($value);
    }
}
