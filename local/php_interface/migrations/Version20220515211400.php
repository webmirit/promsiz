<?php

namespace Sprint\Migration;


class Version20220515211400 extends Version
{
    protected $description = "Свойства каталога";

    protected $moduleVersion = "4.0.6";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->getIblockIdIfExists('aspro_next_catalog', 'aspro_next_catalog');
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Технология (справочник)',
            'ACTIVE' => 'Y',
            'SORT' => '5100',
            'CODE' => 'TECH',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'E',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'XML_ID' => '',
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => 'configurator:tech',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => 'EAutocomplete',
            'USER_TYPE_SETTINGS' =>
                array(
                    'VIEW' => 'A',
                    'SHOW_ADD' => 'N',
                    'MAX_WIDTH' => 0,
                    'MIN_HEIGHT' => 24,
                    'MAX_HEIGHT' => 1000,
                    'BAN_SYM' => ',;',
                    'REP_SYM' => ' ',
                    'OTHER_REP_SYM' => '',
                    'IBLOCK_MESS' => 'N',
                ),
            'HINT' => '',
        ));
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Гладье (справочник)',
            'ACTIVE' => 'Y',
            'SORT' => '5100',
            'CODE' => 'FORM',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'E',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'XML_ID' => '',
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => 'configurator:form',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => 'EAutocomplete',
            'USER_TYPE_SETTINGS' =>
                array(
                    'VIEW' => 'A',
                    'SHOW_ADD' => 'N',
                    'MAX_WIDTH' => 0,
                    'MIN_HEIGHT' => 24,
                    'MAX_HEIGHT' => 1000,
                    'BAN_SYM' => ',;',
                    'REP_SYM' => ' ',
                    'OTHER_REP_SYM' => '',
                    'IBLOCK_MESS' => 'N',
                ),
            'HINT' => '',
        ));
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Упаковка',
            'ACTIVE' => 'Y',
            'SORT' => '5100',
            'CODE' => 'PACK',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'E',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'Y',
            'XML_ID' => '',
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => 'EAutocomplete',
            'USER_TYPE_SETTINGS' =>
                array(
                    'VIEW' => 'A',
                    'SHOW_ADD' => 'N',
                    'MAX_WIDTH' => 0,
                    'MIN_HEIGHT' => 24,
                    'MAX_HEIGHT' => 1000,
                    'BAN_SYM' => ',;',
                    'REP_SYM' => ' ',
                    'OTHER_REP_SYM' => '',
                    'IBLOCK_MESS' => 'N',
                ),
            'HINT' => '',
        ));

    }

    public function down()
    {
    }
}
