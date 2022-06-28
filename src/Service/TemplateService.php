<?php

declare(strict_types=1);

namespace App\Service;

use Exception;

class TemplateService
{
    private $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @throws Exception
     */
    public function render(string $template, array $data = [])
    {
        $path = $this->basePath . $template;

        if (!file_exists($path)) {
            throw new Exception('Template is not exists');
        }

        !$data || extract($data);

        ob_start();

        include $path;

        $buffer = ob_get_contents();
        @ob_end_clean();

        return $buffer;
    }
}
