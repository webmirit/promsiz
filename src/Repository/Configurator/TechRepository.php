<?php

namespace App\Repository\Configurator;

use App\Concern\Typeable;
use App\Repository\BaseIblockRepository;
use CFile;
use CIBlockElement;

class TechRepository extends BaseIblockRepository
{
    use Typeable;

    public function findAllWithCache(): array
    {
        return $this->cache(function () {
            $iterator = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => $this->ibId,
                ],
                false,
                false,
                [
                    'ID',
                    'NAME',
                    'PREVIEW_PICTURE',
                    'CODE',
                    'PREVIEW_TEXT',
                    'DETAIL_TEXT',
                    'DETAIL_PICTURE',
                ]
            );

            $result = [];
            while ([
                'ID' => $id,
                'PREVIEW_PICTURE' => $picture,
                'DETAIL_PICTURE' => $detailPicture,
                'NAME' => $name,
                'CODE' => $code,
                'PREVIEW_TEXT' => $shortDescription,
                'DETAIL_TEXT' => $description,
            ] = $iterator->fetch()) {
                $picture = $picture ? CFile::GetPath($picture) : null;
                $detailPicture = $detailPicture ? CFile::GetPath($detailPicture) : null;
                $result[] = $this->typify(compact('id', 'picture', 'name', 'code', 'shortDescription', 'description', 'detailPicture'));
            }

            return $result;
        }, __METHOD__);
    }
}
