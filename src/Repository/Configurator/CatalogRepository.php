<?php

namespace App\Repository\Configurator;

use App\Concern\Typeable;
use App\Repository\BaseIblockRepository;
use App\Service\Iblock;
use CFile;
use CIBlockElement;
use CIBlockSection;

class CatalogRepository extends BaseIblockRepository
{
    use Typeable;

    private const DEFAULT_EXCLUDE_SECTIONS = [
        'nabory_12_predmetov',
        'kuvshiny',
        'chaynye_nabory_s_blyudtsem',
        'grafiny_dekantery',
        'nabory_s_barnoy_stoykoy',
        'sets',
    ];
    /** @var TechRepository */
    private $techRepository;
    /** @var FormRepository */
    private $formRepository;
    /** @var PackRepository */
    private $packRepository;

    public function __construct(
        string         $ibCode,
        TechRepository $techRepository,
        FormRepository $formRepository,
        PackRepository $packRepository,
        Iblock         $iblock
    )
    {
        parent::__construct($ibCode, $iblock);

        $this->techRepository = $techRepository;
        $this->formRepository = $formRepository;
        $this->packRepository = $packRepository;
    }

    public function findSectionsForConfigurator(): array
    {
        return $this->cache(function () {
            $filter = [
                'IBLOCK_ID' => $this->ibId,
                '=GLOBAL_ACTIVE' => 'Y',
                'DEPTH_LEVEL' => 1,
                '!CODE' => static::DEFAULT_EXCLUDE_SECTIONS, // исключаем сеты
            ];

            $iterator = CIBlockSection::GetList(
                [],
                $filter,
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
        }, __METHOD__ . 'sections');
    }

    public function findProductByFilter(array $filter): array
    {
        $iterator = CIBlockElement::GetList(
            [],
            $filter,
            false,
            false,
            [
                'ID',
                'NAME',
                'PROPERTY_PIC_FORM',
                'PROPERTY_TECH',
                'PROPERTY_FORM',
                'PREVIEW_PICTURE',
                'DETAIL_PICTURE',
                'PREVIEW_TEXT',
                'DETAIL_TEXT',
                'PROPERTY_RISUNOK',
                'PROPERTY_FORM_FOR_SET',
                'PROPERTY_FORM_FOR_SET_2',
                'PROPERTY_PHOTO_WITH_FORM',
                'PROPERTY_PHOTO_CLOSED_SET',
                'PROPERTY_PHOTO_OPENED_SET',
                'PROPERTY_SET_COUNT',
                'IBLOCK_SECTION_ID',
                'PROPERTY_CML2_ARTICLE',
                'PROPERTY_SET_WEIGHT',
                'PROPERTY_SET_VOLUME',
                'PROPERTY_SET_HEIGHT',
            ]
        );

        $result = [];
        while ([
            'ID' => $id,
            'NAME' => $name,
            'PROPERTY_PIC_FORM_VALUE' => $picture,
            'PROPERTY_TECH_VALUE' => $technology,
            'PROPERTY_FORM_VALUE' => $form,
            'DETAIL_PICTURE' => $detailPicture,
            'PREVIEW_PICTURE' => $previewPicture,
            'IBLOCK_SECTION_ID' => $sectionId,
            'DETAIL_TEXT' => $description,
            'PREVIEW_TEXT' => $shortDescription,
            'PROPERTY_RISUNOK_VALUE' => $pattern,
            'PROPERTY_FORM_FOR_SET_VALUE' => $formForSet,
            'PROPERTY_FORM_FOR_SET_2_VALUE' => $formForSet2,
            'PROPERTY_PHOTO_WITH_FORM_VALUE' => $photoWithForm,
            'PROPERTY_PHOTO_CLOSED_SET_VALUE' => $photoClosedForm,
            'PROPERTY_PHOTO_OPENED_SET_VALUE' => $photoOpenedForm,
            'PROPERTY_SET_COUNT_VALUE' => $setCount,
            'PROPERTY_CML2_ARTICLE_VALUE' => $article,
            'PROPERTY_SET_WEIGHT_VALUE' => $setWeight,
            'PROPERTY_SET_VOLUME_VALUE' => $setVolume,
            'PROPERTY_SET_HEIGHT_VALUE' => $setHeight,
        ] = $iterator->fetch()) {
            $picture = !$picture ?: CFile::GetPath($picture);
            $detailPicture = !$detailPicture ?: CFile::GetPath($detailPicture);
            $previewPicture = !$previewPicture ?: CFile::GetPath($previewPicture);
            $photoWithForm = CFile::GetPath($photoWithForm);
            $photoClosedForm = CFile::GetPath($photoClosedForm);
            $photoOpenedForm = CFile::GetPath($photoOpenedForm);

            $result[] = $this->typify(compact(
                'id',
                'name',
                'picture',
                'previewPicture',
                'detailPicture',
                'technology',
                'form',
                'pattern',
                'photoWithForm',
                'photoClosedForm',
                'photoOpenedForm',
                'formForSet',
                'formForSet2',
                'shortDescription',
                'description',
                'setCount',
                'article',
                'setHeight',
                'setVolume',
                'setWeight',
                'sectionId'
            ));
        }

        return $result;
    }


    /**
     * @param int $category
     * @param int|array|null $gladye
     * @param int|array|null $tech
     * @return array
     */
    public function findProduct(int $category, $gladye = null, $tech = null): array
    {
        $filter = array_filter([
            'IBLOCK_ID' => $this->ibId,
            '=PROPERTY_TECH' => $tech,
            '=PROPERTY_FORM' => $gladye,
            'SECTION_ID' => $category,
        ], function ($item) {
            return !empty($item);
        });

        return $this->findProductByFilter($filter);
    }

    public function findSetsByForm($form, ?int $tech = null, array $patterns = []): array
    {
        $filterFormOr = ['=PROPERTY_FORM' => $form];
        $filterFormOr2 = ['=PROPERTY_FORM_FOR_SET' => $form];
        $filterFormOr3 = ['=PROPERTY_FORM_FOR_SET_2' => $form];

        if ($tech) {
            $filterFormOr['PROPERTY_TECH'] = $tech;
            $filterFormOr2['PROPERTY_TECH'] = $tech;
            $filterFormOr3['PROPERTY_TECH'] = $tech;
        }

        if ($patterns) {
            $filterFormOr['PROPERTY_RISUNOK'] = $patterns;
            $filterFormOr2['PROPERTY_RISUNOK'] = $patterns;
            $filterFormOr3['PROPERTY_RISUNOK'] = $patterns;
        }

        $filter = [
            'IBLOCK_ID' => $this->ibId,
            'SECTION_CODE' => 'sets',
            'INCLUDE_SUBSECTIONS' => 'Y',
            [
                'LOGIC' => 'OR',
                $filterFormOr,
                $filterFormOr2,
                $filterFormOr3,
            ],
        ];

        return $this->findProductByFilter($filter);
    }

    //FIXME
    public function findSectionsBySetsCount(int $count): array
    {
        if (empty($count)) {
            return [];
        }

        $sectionSet = CIBlockSection::GetList(
                [],
                ['IBLOCK_ID' => $this->ibId, '=CODE' => 'sets'],
                false,
                ['ID', 'LEFT_MARGIN', 'RIGHT_MARGIN', 'DEPTH_LEVEL']
            )->fetch();

        $subSectionsForExcludeIterator = CIBlockSection::GetList(
            [],
            [
                'IBLOCK_ID' => $this->ibId,
                '>LEFT_MARGIN' => $sectionSet['LEFT_MARGIN'],
                '<RIGHT_MARGIN' => $sectionSet['RIGHT_MARGIN'],
                '>DEPTH_LEVEL' => $sectionSet['DEPTH_LEVEL']
            ],
            false,
            ['ID']
        );

        $sectsIdsForExclude = [];
        while(['ID' => $id] = $subSectionsForExcludeIterator->fetch()) {
            $sectsIdsForExclude[] = $id;
        }

        $sectsIdsForExclude = array_merge($sectsIdsForExclude, [$sectionSet['ID']]);

        $products = $this->findProductByFilter([
            'IBLOCK_ID' => $this->ibId,
            'PROPERTY_SET_COUNT_VALUE' => $count,
            'SECTION_ID' => $sectionSet['ID'],
            'INCLUDE_SUBSECTIONS' => 'Y',
        ]);

        if (!$products) {
            return [];
        }

        $orCriteria = [];
        $formIds = array_values(array_column($products, 'form'));

        $setForms = array_values(array_unique($formIds));

        $products = $this->findProductByFilter([
            'IBLOCK_ID' => $this->ibId,
            'PROPERTY_FORM' => $formIds,
            '!SECTION_ID' => $sectsIdsForExclude,
            array_merge([
                'LOGIC' => 'OR',

            ], $orCriteria)
        ]);
        $sections = array_values(array_unique(array_column($products, 'sectionId')));

        return compact('setForms', 'sections');
    }

    public function findCategoriesByFilter(?int $gladye = null, ?int $techId = null): array
    {
        $filter = array_filter([
            'IBLOCK_ID' => $this->ibId,
            '=PROPERTY_TECH' => $techId,
            '=PROPERTY_FORM' => $gladye,
            '!CODE' => static::DEFAULT_EXCLUDE_SECTIONS // исключаем сеты
        ], function ($item) {
            return !empty($item);
        });

        $iterator = CIBlockElement::GetList(
            [],
            $filter,
            false,
            false,
            [
                'ID',
            ]
        );

        $itemsIds = [];
        while (['ID' => $id] = $iterator->fetch()) {
            $itemsIds[] = $id;
        }

        return $this->findCategoriesByItemsIds($itemsIds);
    }

    public function findCategoriesByItemsIds(array $itemsIds)
    {
        if (empty($itemsIds)) {
            return [];
        }

        $iterator = CIBlockElement::GetElementGroups(
            $itemsIds,
            true,
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

    // FIXME optimize
    public function findSectionsByPacks(int $sectionId, int $count, ?int $categoryId = null): array
    {
        if (empty($sectionId) || empty($count)) {
            return [];
        }

        if (empty($packIds = array_column($this->packRepository->findPacksBySection($sectionId, $count), 'id'))) {
            return [];
        }

        $sectionIds = array_column(
            $this->findProductByFilter([
                    'IBLOCK_ID' => $this->ibId,
                    'PROPERTY_PACK' => $packIds,
                ]
            ), 'sectionId');

        if (empty($sectionIds)) {
            return [];
        }

        $sectionIdForExclude = CIBlockSection::GetList(
                [],
                ['IBLOCK_ID' => $this->ibId, '=CODE' => 'sets'],
                false,
                ['ID',]
            )->fetch()['ID'] ?? null;

        if (empty($sectionIdForExclude)) {
            return [];
        }

        $sectionsIterator = CIBlockSection::GetList(
            [],
            ['IBLOCK_ID' => $this->ibId, '!SECTION_ID' => $sectionIdForExclude, 'ID' => $sectionIds],
            false,
            ['ID', 'NAME', 'PICTURE']
        );

        $sections = [];
        while (['ID' => $id, 'PICTURE' => $picture, 'NAME' => $name] = $sectionsIterator->fetch()) {
            $picture = $picture ? \CFile::GetPath($picture) : null;
            $sections[] = $this->typify(compact('id', 'picture', 'name'));
        }

        return $sections;
    }

    public function findByProductSectionAndPack(int $productSectionId, int $packCount, int $packSection): array
    {
        if (!$productSectionId || !$packCount || !$packSection) {
            return [];
        }

        if (empty($packs = $this->packRepository->findPacksBySection($packSection, $packCount))) {
            return [];
        }

        $packsIds = array_column($packs, 'id');

        return array_column($this->findProductByFilter([
            'IBLOCK_ID' => $this->ibId,
            'SECTION_ID' => $productSectionId,
            'PROPERTY_PACK' => $packsIds
        ]), 'form');
    }
}
