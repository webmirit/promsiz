<?php

namespace App\Repository\Configurator;

use App\Repository\BaseIblockRepository;
use Exception;

class LetterRepository extends BaseIblockRepository
{
    /**
     * @throws Exception
     */
    public function addLetter(string $text): int
    {
        return $this->add([
            'NAME' => hash('sha1', $text),
            'PREVIEW_TEXT' => $text,
            'IBLOCK_ID' => $this->ibId,
        ]);
    }
}
