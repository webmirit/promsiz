<?php

namespace App\Entity;

use App\Entity\Concern\DataFetchModifiable;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;

class TechTable extends DataManager
{
    use DataFetchModifiable;

    public static function getTableName(): string
    {
        return 'milky_web_tech';
    }

    public static function getMap(): array
    {
        return [
            new Fields\IntegerField('id', [
                'column_name' => 'ID',
                'primary' => true,
                'autocomplete' => true,
                'fetch_data_modification' => self::getModifications(['int']),
            ]),
            new Fields\StringField('name', [
                'required' => true,
                'column_name' => 'UF_NAME',
            ]),
            new Fields\StringField('code', [
                'required' => true,
                'column_name' => 'UF_CODE',
            ]),
            new Fields\StringField('description', [
                'required' => true,
                'column_name' => 'UF_DESCRIPTION',
            ]),
            new Fields\IntegerField('picture', [
                'required' => true,
                'column_name' => 'UF_PICTURE',
                'fetch_data_modification' => self::getModifications(['filePath']),
            ]),
        ];
    }
}
