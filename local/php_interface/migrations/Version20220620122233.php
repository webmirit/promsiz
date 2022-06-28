<?php

namespace Sprint\Migration;


class Version20220620122233 extends Version
{
    protected $description = "ФОТО ЗАКРТОЕ И ОТКРЫТОЕ";

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
            'NAME' => 'Фото открытого сета',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'PHOTO_OPENED_SET',
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
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Фото закрытого сета',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'PHOTO_CLOSED_SET',
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
