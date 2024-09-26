<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Engines\AbstractEngines;

class EndActivity extends AbstractEngines
{
    public function execute(string $message): string
    {
        return $message . ' - End';
    }
}