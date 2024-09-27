<?php

declare(strict_types=1);

namespace App\Logger\Activities;

use App\Core\Activities\AbstractActivity;

class LoggerActivity extends AbstractActivity
{
    public function execute(string $message): string
    {
        return 'Rapport inter invest : '.$message;
    }

}