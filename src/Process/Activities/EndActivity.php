<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Activities\AbstractActivity;

class EndActivity extends AbstractActivity
{
    public function execute(string $message): string
    {
        return $message . ' - End';
    }
}