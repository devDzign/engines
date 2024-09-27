<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Engines\AbstractEngines;

class SevenActivity extends AbstractEngines
{

    public function execute(string $message): string
    {
        return $message . ' - Seven';
    }
}