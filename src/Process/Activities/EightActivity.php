<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Engines\AbstractEngines;

class EightActivity extends AbstractEngines
{


    public function execute(string $message, bool $decision =  false): array
    {
        return [
            'response' => $decision,
            'message' => $message
        ];
    }
}