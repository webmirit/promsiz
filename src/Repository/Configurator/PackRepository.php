<?php

namespace App\Repository\Configurator;

use App\Concern\Typeable;
use App\Repository\BaseIblockRepository;
use CFile;
use CIBlockElement;
use CIBlockSection;

class PackRepository extends BaseIblockRepository
{
    use Typeable;

    /**
     * Получаем список упаковок
     *
     * [
     *      [
     *          'name' => 'Упаковка 1',
     *          'count' => 1,
     *          'id' => 1, // id упаковки
     *          'form' => 1, // id гладья/формы
     *          'picture' => '/path/to/pic.jpg',
     *       ]
     * ]
     *
     * @return array
     */
    public function findAllPacks(): array
    {
        return $this->cache(function () {
            return $this->findPacksByFilter();
        }, __METHOD__ . 'all');
    }

    private function findPacksByFilter(array $filter = []): array
    {
        $filter = array_merge($filter, ['IBLOCK_ID' => $this->ibId]);

        $iterator = CIBlockElement::GetList(
            [],
            $filter,
            false,
            false,
            [
                'ID',
                'PROPERTY_COUNT',
                'PROPERTY_FORM',
                'NAME',
                'PREVIEW_PICTURE',
                'IBLOCK_SECTION_ID',
                'PROPERTY_VOLUME',
                'PROPERTY_HEIGHT',
                'PROPERTY_WEIGHT',
            ]
        );

        $result = [];
        while ([
            'ID' => $id,
            'PROPERTY_COUNT_VALUE' => $count,
            'NAME' => $name,
            'PROPERTY_FORM_VALUE' => $form,
            'IBLOCK_SECTION_ID' => $type,
            'PREVIEW_PICTURE' => $picture,
            'PROPERTY_VOLUME_VALUE' => $volume,
            'PROPERTY_HEIGHT_VALUE' => $height,
            'PROPERTY_WEIGHT_VALUE' => $weight,
        ] = $iterator->fetch()) {
            $picture = CFile::GetPath($picture);
            $result[] = $this->typify(compact('id', 'count', 'name', 'form', 'type', 'picture', 'volume', 'height', 'weight'));
        }

        return $result;
    }

    /**
     * Получаем список упаковок
     *
     * [
     *      [
     *          'name' => 'Упаковка 1',
     *          'count' => 1,
     *          'id' => 1, // id упаковки
     *          'form' => 1, // id гладья/формы
     *          'picture' => '/path/to/pic.jpg',
     *      ]
     * ]
     *
     * @param int $formId
     * @return array
     */
    public function findPacksByForm(int $formId): array
    {
        return $this->findPacksByFilter(['PROPERTY_FORM' => $formId]);
    }

    /**
     * Получить типы упаковок (разделы)
     *
     * [
     *      [
     *          'name' => 'Закрытая',
     *          'picture' => '/path/to/pic.jpg',
     *          'id' => 1, // id типа упаковки
     *      ]
     * ]
     *
     * @return array
     */
    public function findTypesOfPack(): array
    {
        $iterator = CIBlockSection::GetList(
            [],
            [
                'IBLOCK_ID' => $this->ibId,
            ],
            false,
            [
                'ID',
                'NAME',
                'PICTURE',
            ]
        );

        $result = [];
        while (['ID' => $id, 'PICTURE' => $picture, 'NAME' => $name] = $iterator->fetch()) {
            $picture = CFile::GetPath($picture);
            $result[] = $this->typify(compact('id', 'picture', 'name'));
        }

        return $result;
    }

    public function findPacksBySection(int $sectionId, int $count): array
    {
        return $this->findPacksByFilter(['SECTION_ID' => $sectionId, 'PROPERTY_COUNT_VALUE' => $count]);
    }
}
