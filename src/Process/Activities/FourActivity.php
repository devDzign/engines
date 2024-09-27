<?php

declare(strict_types=1);

namespace App\Process\Activities;



use App\Core\Activities\AbstractActivity;

class FourActivity extends AbstractActivity
{

    public function execute(string $message): string
    {
        return $message . ' - Four';
    }
}