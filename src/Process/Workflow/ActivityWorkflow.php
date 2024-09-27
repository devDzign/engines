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
use App\Process\Activities\SevenActivity;
use App\Process\Activities\SixActivity;
use App\Process\Activities\TenActivity;
use App\Process\Activities\ThreeActivity;
use App\Process\Activities\TwoActivity;


class ActivityWorkflow extends AbstractInterInvestWorkflow
{

    /**
     * @throws \Exception
     */
    public function execute(string $message): string
    {

        $stepOne   = $this->make(OneActivity::class)->execute($message);
        $stepTwo   = $this->make(TwoActivity::class)->execute($stepOne);
        $stepThree = $this->make(ThreeActivity::class)->execute($stepTwo);
        $stepFour  = $this->make(FourActivity::class)->execute($stepThree);
        $stepFive  = $this->make(FiveActivity::class)->execute($stepFour, true);

        $stepSixOrSaven = match ($stepFive['response']) {
             true =>  $this->make(SixActivity::class)->execute($stepFive['message']),
             false =>  $this->make(SevenActivity::class)->execute($stepFive['message'])
        };


        $stepEight = $this->make(EightActivity::class)->execute($stepSixOrSaven, true);

        $stepNineOrTen = match ($stepEight['response']) {
            true =>  $this->make(NineActivity::class)->execute($stepEight['message']),
            false =>  $this->make(TenActivity::class)->execute($stepEight['message'])
        };


        return $this->make(EndActivity::class)->execute($stepNineOrTen);
    }




}