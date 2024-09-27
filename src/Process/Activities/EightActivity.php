<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Activities\AbstractActivity;

class EightActivity extends AbstractActivity
{


    public function execute(string $message, bool $decision =  false): array
    {
        return [
            'response' => $decision,
            'message' => $message
        ];
    }
}