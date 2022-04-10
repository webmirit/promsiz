<?php
/**
 * Класс в котором будут собраны вызовы всех событий, чтобы не писать простыню в init.php
 */

namespace XFive\Events;


class EventManager
{
    public function initEvents()
    {
        $bxEventManager = \Bitrix\Main\EventManager::getInstance();

        //x5
        /** 29672 x5 P.S.
         *  Так как в 1с у них там что-то криво делаем фитчу
         *  - при добавлении или редактировании элемента выгрузкой из 1с меняем имя с кастомным именем из 1с местами
         *  - при добавлении или редактировании св-ва инфоблока заменяем имя св-ва на нужное нам
         */
        //name
        $bxEventManager->addEventHandler(
            "iblock",
            "OnBeforeIBlockElementAdd",
            array(
                "XFive\Import\ExchangePropsChanger",
                "OnBeforeIBlockElementAddAndUpdateHandler",
            )
        );
        $bxEventManager->addEventHandler(
            "iblock",
            "OnBeforeIBlockElementUpdate",
            array(
                "XFive\Import\ExchangePropsChanger",
                "OnBeforeIBlockElementAddAndUpdateHandler",
            )
        );
        //!name
        //prop
        $bxEventManager->addEventHandler(
            "iblock",
            "OnBeforeIBlockPropertyAdd",
            array(
                "XFive\Import\ExchangePropsChanger",
                "OnBeforeIBlockPropertyAddHandler",
            )
        );
        $bxEventManager->addEventHandler(
            "iblock",
            "OnBeforeIBlockPropertyUpdate",
            array(
                "XFive\Import\ExchangePropsChanger",
                "OnBeforeIBlockPropertyUpdateHandler",
            )
        );
        //!prop
        //!x5

        $bxEventManager->addEventHandler(
            "iblock",
            "OnAfterIBlockElementAdd",
            array(
                "XFive\Iblock\IblockHandler",
                "OnAfterIBlockElementAddAndUpdateHandler",
            )
        );

        $bxEventManager->addEventHandler(
            "iblock",
            "OnAfterIBlockElementUpdate",
            array(
                "XFive\Iblock\IblockHandler",
                "OnAfterIBlockElementAddAndUpdateHandler",
            )
        );

        $bxEventManager->addEventHandler(
            "iblock",
            "OnAfterIBlockSectionUpdate",
            array(
                "XFive\Iblock\IblockHandler",
                "OnAfterIBlockSectionUpdateHandler",
            )
        );

        $bxEventManager->addEventHandler(
            "iblock",
            "OnAfterIBlockSectionDelete",
            array(
                "XFive\Iblock\IblockHandler",
                "OnAfterIBlockSectionDeleteHandler",
            )
        );
    }
}
