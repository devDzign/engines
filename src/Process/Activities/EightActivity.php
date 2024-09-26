<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Engines\AbstractEngines;

class EightActivity extends AbstractEngines
{

    /**
     * @param ...$arg
     * @return string[]
     */
    public function execute(...$arg): array
    {
        $message =  $arg[0];

        return ['response'=> 'oui', 'message' => $message . ' - Eight'];
    }
}