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

        $stepOne   = $this->make(OneActivity::class)->execute(...$this->arguments);
        $stepTwo   = $this->make(TwoActivity::class)->execute($stepOne);
        $stepThree = $this->make(ThreeActivity::class)->execute($stepTwo);
        $stepFour  = $this->make(FourActivity::class)->execute($stepThree);
        $stepFive  = $this->make(FiveActivity::class)->execute($stepFour);

        $stepSixOrSaven = match ($stepFive['response']) {
            'oui' =>  $this->make(SixActivity::class)->execute($stepFive['message']),
            'non' =>  $this->make(SavenActivity::class)->execute($stepFive['message'])
        };

        $stepEight = $this->make(EightActivity::class)->execute($stepSixOrSaven);

        $stepNineOrTen = match ($stepEight['response']) {
            'oui' =>  $this->make(NineActivity::class)->execute($stepEight['message']),
            'non' =>  $this->make(TenActivity::class)->execute($stepEight['message'])
        };


        return $this->make(EndActivity::class)->execute($stepNineOrTen);
    }


//    /**
//     * @throws \Exception
//     */
//    public function start(): string
//    {
//        $stepFive = $this->loadEngine(FiveActivity::class)->execute(
//            $this->loadEngine(FourActivity::class)->execute(
//                $this->loadEngine(ThreeActivity::class)->execute(
//                    $this->loadEngine(TwoActivity::class)->execute(
//                        $this->loadEngine(OneActivity::class)->execute(...$this->arguments)
//                    )
//                )
//            )
//        );
//
//        $stepSixOrSaven = match ($stepFive['response']) {
//            'oui' => $this->loadEngine(SixActivity::class)->execute($stepFive['message']),
//            'non' => $this->loadEngine(SavenActivity::class)->execute($stepFive['message'])
//        };
//
//        $stepEight = $this->loadEngine(EightActivity::class)->execute($stepSixOrSaven);
//
//        $stepNineOrTen = match ($stepEight['response']) {
//            'oui' => $this->loadEngine(NineActivity::class)->execute($stepEight['message']),
//            'non' => $this->loadEngine(TenActivity::class)->execute($stepEight['message'])
//        };
//
//
//        return $this->loadEngine(EndActivity::class)->execute($stepNineOrTen);
//    }

}