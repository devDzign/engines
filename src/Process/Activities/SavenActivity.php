<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Engines\AbstractEngines;

class SavenActivity extends AbstractEngines
{

    public function execute(...$arg): mixed
    {
        $message =  $arg[0];

        return $message . ' - Saven';
    }
}