<?php

namespace XFive\Iblock;

use XFive\Conf;

class IblockHandler
{
    /**
     * Проставляем для элемента значение свойства SECTION (устанавливаем корневой раздел для использования в умном фильтре)
     *
     * @param &$arFields
     */
    public static function OnAfterIBlockElementAddAndUpdateHandler(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == Conf::CATALOG_IBLOCK_ID && !empty($arFields['ID'])) {
            $dbElem = \CIBlockElement::GetList(
                Array(),
                Array('IBLOCK_ID' => Conf::CATALOG_IBLOCK_ID, 'ID' => $arFields['ID']),
                false,
                array('nTopCount' => 1),
                Array('ID', 'IBLOCK_SECTION_ID')
            );
            if ($arElem = $dbElem->Fetch()) {
                $arSect = \CIBlockSection::GetList(
                    array(),
                    array('=ID' => $arElem['IBLOCK_SECTION_ID'], 'IBLOCK_ID' => Conf::CATALOG_IBLOCK_ID, 'DEPTH_LEVEL' => 1),
                    false,
                    array('nTopCount' => 1),
                    array('ID', 'NAME')
                )->Fetch();

                if (!empty($arSect['ID'])) {
                    $arrPropValue = \CIBlockProperty::GetPropertyEnum(
                        'SECTION',
                        array("SORT" => "asc"),
                        array('IBLOCK_ID' => Conf::CATALOG_IBLOCK_ID, 'XML_ID' => $arSect['ID'])
                    )->Fetch();

                    if (empty($arrPropValue['ID'])) {
                        $arrProp = \CIBlockProperty::GetByID('SECTION', Conf::CATALOG_IBLOCK_ID)->Fetch();
                        if (!empty($arrProp)) {
                            $newEnum = new \CIBlockPropertyEnum;
                            $arrPropValue['ID'] = $newEnum->Add(Array('PROPERTY_ID' => $arrProp['ID'], 'VALUE' => $arSect['NAME'], 'XML_ID' => $arSect['ID']));
                        }
                    }

                    if (!empty($arrPropValue['ID'])) {
                        \CIBlockElement::SetPropertyValuesEx($arFields['ID'], Conf::CATALOG_IBLOCK_ID, array('SECTION' => $arrPropValue['ID']));
                        \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex(Conf::CATALOG_IBLOCK_ID, $arFields['ID']);
                    }
                }
            }
        }
    }

    /**
     * Обновляем название значения свойства SECTION при изменении раздела
     *
     * @param $arFields
     */
    public static function OnAfterIBlockSectionUpdateHandler(&$arFields)
    {
        if ($arFields["IBLOCK_ID"] == Conf::CATALOG_IBLOCK_ID && !empty($arFields['ID'])) {
            $arrPropValue = \CIBlockProperty::GetPropertyEnum(
                'SECTION',
                array("SORT" => "asc"),
                array('IBLOCK_ID' => Conf::CATALOG_IBLOCK_ID, 'XML_ID' => $arFields['ID'])
            )->Fetch();

            if (!empty($arrPropValue['ID'])) {
                $updEnum = new \CIBlockPropertyEnum;
                $updEnum->Update($arrPropValue['ID'], Array('VALUE' => $arFields['NAME']));
            }
        }
    }

    /**
     * Удаляем значение свойства SECTION при удалении раздела
     *
     * @param $arrSect
     */
    public static function OnAfterIBlockSectionDeleteHandler($arrSect)
    {
        if ($arrSect["IBLOCK_ID"] == Conf::CATALOG_IBLOCK_ID && !empty($arrSect['ID'])) {
            $arrPropValue = \CIBlockProperty::GetPropertyEnum(
                'SECTION',
                array("SORT" => "asc"),
                array('IBLOCK_ID' => Conf::CATALOG_IBLOCK_ID, 'XML_ID' => $arrSect['ID'])
            )->Fetch();

            if (!empty($arrPropValue['ID'])) {
                $updEnum = new \CIBlockPropertyEnum;
                $updEnum->Delete($arrPropValue['ID']);
            }
        }
    }
}