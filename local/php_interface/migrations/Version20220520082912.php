<?php

namespace Sprint\Migration;


class Version20220520082912 extends Version
{
    protected $description = "Картинка гладья с технологией (каталог)";

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
            'NAME' => 'Фото гладья с технологией',
            'ACTIVE' => 'Y',
            'SORT' => '5100',
            'CODE' => 'PIC_FORM',
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
