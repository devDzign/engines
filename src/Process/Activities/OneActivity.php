<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Engines\AbstractEngines;

class OneActivity extends AbstractEngines
{

    public function execute(...$arg): string
    {

        $message =  $arg['message'];

        return $message . ' - One';
    }
}