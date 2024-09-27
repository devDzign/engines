<?php

declare(strict_types=1);

namespace App\Process\Workflow;

use App\Core\Activities\ActivityInterface;
use App\Core\Workflow\AbstractIIWorkflow;
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


class Activity2Workflow extends AbstractIIWorkflow
{
    public const string WORKFLOW_NAME = 'activity2.workflow';

    /**
     * @throws \Exception
     */
    public function execute(string $message = 'Init'): string
    {
        [
            $activityOne,
            $activityTwo,
            $activityThree,
            $activityFour,
            $activityFive,
            $activitySix,
            $activitySeven,
            $activityEight,
            $activityNine,
            $activityTen,
            $activityEnd
        ] = $this->initActivities();


        $response   = $activityOne->execute($message);
        $response   = $activityTwo->execute($response);
        $response = $activityThree->execute($response);
        $response  = $activityFour->execute($response);
        $activityFiveResponse  = $activityFive->execute($response, false);

        $response = match ($activityFiveResponse['response']) {
            true => $activitySix->execute($activityFiveResponse['message']),
            false => $activitySeven->execute($activityFiveResponse['message'])
        };

        $stepEightResponse = $activityEight->execute($response, true);

        $response = match ($stepEightResponse['response']) {
            true => $activityNine->execute($stepEightResponse['message']),
            false => $activityTen->execute($stepEightResponse['message'])
        };

        return $activityEnd->execute($response);
    }


    /**
     * Initializes and returns an array of activity instances.
     *
     * @return array{
     *     OneActivity,
     *     TwoActivity,
     *     ThreeActivity,
     *     FourActivity,
     *     FiveActivity,
     *     SixActivity,
     *     SevenActivity,
     *     EightActivity,
     *     NineActivity,
     *     TenActivity,
     *     EndActivity
     * }
     * @throws \Exception
     */

    public function initActivities(): array
    {
        $activityOne   = $this->make(OneActivity::class);
        $activityTwo   = $this->make(TwoActivity::class);
        $activityThree = $this->make(ThreeActivity::class);
        $activityFour  = $this->make(FourActivity::class);
        $activityFive  = $this->make(FiveActivity::class);
        $activitySix   = $this->make(SixActivity::class);
        $activitySeven = $this->make(SevenActivity::class);
        $activityEight = $this->make(EightActivity::class);
        $activityNine  = $this->make(NineActivity::class);
        $activityTen   = $this->make(TenActivity::class);
        $activityEnd   = $this->make(EndActivity::class);

        return [
            $activityOne,
            $activityTwo,
            $activityThree,
            $activityFour,
            $activityFive,
            $activitySix,
            $activitySeven,
            $activityEight,
            $activityNine,
            $activityTen,
            $activityEnd,
        ];
    }


}