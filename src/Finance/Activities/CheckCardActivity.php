<?php

declare(strict_types=1);

namespace App\Finance\Activities;

use App\Core\Activities\AbstractActivity;

class CheckCardActivity extends AbstractActivity
{
    public function execute(): string
    {
        return 'Rapport inter invest';
    }
}
