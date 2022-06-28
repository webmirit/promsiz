<?php

namespace Sprint\Migration;


class Version20220606051725 extends Version
{
    protected $description = "Поля";

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
            'NAME' => 'Гладье для сета',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'FORM_FOR_SET',
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
            'USER_TYPE' => NULL,
            'USER_TYPE_SETTINGS' => NULL,
            'HINT' => '',
        ));
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Гладье для сета 2',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'FORM_FOR_SET_2',
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
            'USER_TYPE' => NULL,
            'USER_TYPE_SETTINGS' => NULL,
            'HINT' => '',
        ));
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Общее фото с гладьем',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'PHOTO_WITH_FORM',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'F',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'XML_ID' => '',
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => NULL,
            'USER_TYPE_SETTINGS' => NULL,
            'HINT' => '',
        ));

    }

    public function down()
    {
        //your code ...
    }
}
