<?php

namespace XFive\Import;

class ExchangePropsChanger
{
    public static $iblockIds = array(
        \XFive\Conf::CATALOG_IBLOCK_ID,
        \XFive\Conf::OFFERS_IBLOCK_ID
    );
    //ключ это то - что надо переименовать[NAME]
    //значение это то - какое имя будет в итоге
    /** x5 P.S.
     * @var array :
     *  - ключ это код(привязка по коду) того св-ва, которое надо переименовать [NAME][VALUE]
     *  - значение это то - какое имя будет в итоге
     */
    public static $renamePropsCode = [
        'VYSOTA_H_MM' => "Высота",
        'DEKOR'=> 'Декор',
        'NAIMENOVANIE_GLADYA_1'=> 'Серия посуды',
        'NAIMENOVANIE_DLYA_SAYTA'=> 'Наименование',
        'OBYEM_ML_'=> 'Объем',
        'TEKHNOLOGIYA_2'=> 'Технология',
        'DIAMETR'=> 'Диаметр',
    ];

    public static $propNaimenovanie = "";

    /** x5 P.S. При добавлении замена названия элемента на значение из свойства, выполняется только для выгрузки
     * @param $arFields
     */
    function OnBeforeIBlockPropertyAddHandler(&$arFields)
    {
        if ($_GET['type'] === 'catalog' && $_GET['mode'] === 'import' && in_array($arFields["IBLOCK_ID"], self::$iblockIds)) {
            if (isset(self::$renamePropsCode[$arFields["CODE"]])) {
                $arFields["NAME"] = self::$renamePropsCode[$arFields["CODE"]];
            }
        }
    }

    /** x5 P.S. При обновлении замена названия элемента на значение из свойства, выполняется только для выгрузки
     * @param $arFields
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     */
    function OnBeforeIBlockPropertyUpdateHandler(&$arFields)
    {
        if ($_GET['type'] === 'catalog' && $_GET['mode'] === 'import') {
            if (\Bitrix\Main\Loader::includeModule('iblock') && $arFields["ID"]){
                $dbProperty = \Bitrix\Iblock\PropertyTable::getList(array(
                    'select' => array('CODE'),
                    'filter' => array('=ID' => $arFields["ID"])
                ));
                $property = $dbProperty->fetch();

                if (isset(self::$renamePropsCode[$property["CODE"]])) {
                    $arFields["NAME"] = self::$renamePropsCode[$property["CODE"]];
                }
            }
        }
    }

    /** x5 P.S.
     * @param $propCode - CODE св-ва
     * @return string - ID св-ва
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     */
    public static function getProp($propCode)
    {
        if(!self::$propNaimenovanie){
            if (\Bitrix\Main\Loader::includeModule('iblock')){

                $dbProperty = \Bitrix\Iblock\PropertyTable::getList(array(
                    'select' => array('ID'),
                    'filter' => array('=CODE' => $propCode)
                ));
                $property = $dbProperty->fetch();
                self::$propNaimenovanie = $property['ID'];
            }
        }
        return self::$propNaimenovanie;
    }

    /** x5 P.S. При обновлении товара меняется местами значение NAME c значением нужного поля(по его CODE), выполняется только для выгрузки
     * @param $arFields
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     */
    public static function OnBeforeIBlockElementAddAndUpdateHandler(&$arFields)
    {
        global $USER;
        $login = $USER->GetLogin();

        if ($login == \XFive\Conf::USER_1C && $_GET['type'] === 'catalog' && $_GET['mode'] === 'import' && in_array($arFields["IBLOCK_ID"], self::$iblockIds)) {
            if(\XFive\Conf::PROP_NAME){
                $propId = self::getProp(\XFive\Conf::PROP_NAME);
            }

            if($propId){
                foreach ($arFields["PROPERTY_VALUES"][$propId] as $key => $row) {
                    $propValue = $row['VALUE'];
                    if ($propValue) {
                        break;
                    }
                }
                if($propValue) {
                    if ($arFields["NAME"]) {
                        $arFields["PROPERTY_VALUES"][$propId] = array();
                        $arFields["PROPERTY_VALUES"][$propId][0]['VALUE'] = $arFields["NAME"];
                    }
                    $arFields["NAME"] = $propValue;
                }
            }
        }
    }

}
