<?php

declare(strict_types=1);

namespace App\Process\Workflow;

use App\Core\Engines\EngineInterface;
use App\Core\Workflow\AbstractInterInvestWorkflow;
use App\Process\Activities\EightActivity;
use App\Process\Activities\EndActivity;
use App\Process\Activities\FiveActivity;
use App\Process\Activities\FourActivity;
use App\Process\Activities\NineActivity;
use App\Process\Activities\OneActivity;
use App\Process\Activities\SavenActivity;
use App\Process\Activities\SixActivity;
use App\Process\Activities\TenActivity;
use App\Process\Activities\ThreeActivity;
use App\Process\Activities\TwoActivity;


class ActivityWorkflow extends AbstractInterInvestWorkflow
{
    /**
     * @throws \Exception
     */
    public function start(): string
    {
        $stepOne   = $this->loadEngine(OneActivity::class)->execute(...$args);
        $stepTwo   = $this->loadEngine(TwoActivity::class)->execute($stepOne);
        $stepThree = $this->loadEngine(ThreeActivity::class)->execute($stepTwo);
        $stepFour  = $this->loadEngine(FourActivity::class)->execute($stepThree);
        $stepFive  = $this->loadEngine(FiveActivity::class)->execute($stepFour);

        $stepSixOrSaven = match ($stepFive[0]) {
            'oui' =>  $this->loadEngine(SixActivity::class)->execute($stepFive[1]),
            'non' =>  $this->loadEngine(SavenActivity::class)->execute($stepFive[1])
        };

        $stepEight = $this->loadEngine(EightActivity::class)->execute($stepSixOrSaven);

        $stepNineOrTen = match ($stepEight[0]) {
            'oui' =>  $this->loadEngine(NineActivity::class)->execute($stepEight[1]),
            'non' =>  $this->loadEngine(TenActivity::class)->execute($stepEight[1])
        };

        $stepEnd = $this->loadEngine(EndActivity::class)->execute($stepNineOrTen);

        return $stepEnd;
    }
}