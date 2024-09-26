<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Engines\AbstractEngines;

class FiveActivity extends AbstractEngines
{

    public function execute(...$arg): array
    {
        $message =  $arg[0];

        return ['non', $message . ' - Five'];
    }
}