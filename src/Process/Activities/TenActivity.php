<?php

declare(strict_types=1);

namespace App\Process\Activities;


use App\Core\Engines\AbstractEngines;

class TenActivity extends AbstractEngines
{

    public function execute(...$arg): string
    {
        $message =  $arg[0];

        return $message . ' - Ten';
    }
}