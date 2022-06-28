<?php

namespace Sprint\Migration;

class Version20220529182417 extends Version
{
    protected $description = "Письмо из конфигуратора";

    protected $moduleVersion = "4.0.6";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Event()->saveEventType('CONFIGURATOR_ORDER', array(
            'LID' => 'ru',
            'EVENT_TYPE' => 'email',
            'NAME' => 'Заказ из конфигуратора',
            'DESCRIPTION' => '',
            'SORT' => '150',
        ));
        $helper->Event()->saveEventType('CONFIGURATOR_ORDER', array(
            'LID' => 'en',
            'EVENT_TYPE' => 'email',
            'NAME' => '',
            'DESCRIPTION' => '',
            'SORT' => '150',
        ));
        $helper->Event()->saveEventMessage('CONFIGURATOR_ORDER', array(
            'LID' =>
                array(
                    0 => 's1',
                ),
            'ACTIVE' => 'Y',
            'EMAIL_FROM' => 'Официальный сайт производителя Гусь-Хрустальный Стекольный Завод (ООО ПромСИЗ)<noreply@ghsz.ru>',
            'EMAIL_TO' => 'anton.tsarkov@dalee.ru',
            'SUBJECT' => 'Заказ из конфигуратора',
            'MESSAGE' => '#HTML#',
            'BODY_TYPE' => 'html',
            'BCC' => '',
            'REPLY_TO' => '',
            'CC' => '',
            'IN_REPLY_TO' => '',
            'PRIORITY' => '',
            'FIELD1_NAME' => '',
            'FIELD1_VALUE' => '',
            'FIELD2_NAME' => '',
            'FIELD2_VALUE' => '',
            'SITE_TEMPLATE_ID' => '',
            'ADDITIONAL_FIELD' =>
                array(),
            'LANGUAGE_ID' => 'ru',
            'EVENT_TYPE' => '[ CONFIGURATOR_ORDER ] Заказ из конфигуратора',
        ));
    }

    public function down()
    {
        //your code ...
    }
}
