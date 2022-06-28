<?php

namespace App\Repository\Configurator;

use App\Concern\Typeable;
use App\Repository\BaseIblockRepository;
use App\Service\Iblock;
use CFile;
use CIBlockElement;

class FormRepository extends BaseIblockRepository
{
    use Typeable;

    public function findAllWithCache(): array
    {
        return $this->findByFilterCached([
            'IBLOCK_ID' => $this->ibId,
        ]);
    }

    public function findByFilterCached(array $filter = []): array
    {
        return $this->cache(function () use ($filter) {
            $iterator = CIBlockElement::GetList(
                [],
                $filter,
                false,
                false,
                [
                    'ID',
                    'NAME',
                    'PREVIEW_PICTURE',
                    'PREVIEW_TEXT',
                    'DETAIL_TEXT',
                    'CODE',
                    'PROPERTY_VOLUME',
                    'PROPERTY_HEIGHT',
                    'PROPERTY_CATEGORY',
                ]
            );

            $result = [];
            while ([
                'ID' => $id,
                'PREVIEW_PICTURE' => $picture,
                'PREVIEW_TEXT' => $shortDescription,
                'DETAIL_TEXT' => $description,
                'NAME' => $name,
                'PROPERTY_VOLUME_VALUE' => $volume,
                'PROPERTY_HEIGHT_VALUE' => $height,
                'PROPERTY_CATEGORY_VALUE' => $category,
            ] = $iterator->fetch()) {
                $picture = CFile::GetPath($picture);
                $result[] = $this->typify(compact('id', 'picture', 'name', 'shortDescription', 'description', 'volume', 'height', 'category'));
            }

            return $result;
        }, md5(__METHOD__ . serialize($filter)));
    }

    public function findByCategoryCache(int $category): array
    {
        return $this->findByFilterCached([
            'IBLOCK_ID' => $this->ibId,
            '=PROPERTY_CATEGORY' => $category,
        ]);
    }
}
