<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Engines\AbstractEngines;

class SavenActivity extends AbstractEngines
{

    public function execute(string $message): string
    {
        return $message . ' - Saven';
    }
}