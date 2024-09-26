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


class Activity2Workflow extends AbstractInterInvestWorkflow
{
    /**
     * @throws \Exception
     */
    public function execute(string $message): string
    {
        [
            $activityOne,
            $activityTwo,
            $activityThree,
            $activityFour,
            $activityFive,
            $activitySix,
            $activitySaven,
            $activityEight,
            $activityNine,
            $activityTen,
            $activityEnd
        ] = $this->initActivities();


        $activityOneResponse   = $activityOne->execute($message);
        $activityTwoResponse   = $activityTwo->execute($activityOneResponse);
        $activityThreeResponse = $activityThree->execute($activityTwoResponse);
        $activityFourResponse  = $activityFour->execute($activityThreeResponse);
        $activityFiveResponse  = $activityFive->execute($activityFourResponse, false);


        $activitySixOrSavenResponse = match ($activityFiveResponse['response']) {
            true => $activitySix->execute($activityFiveResponse['message']),
            false => $activitySaven->execute($activityFiveResponse['message'])
        };

        $stepEightResponse = $activityEight->execute($activitySixOrSavenResponse, true);

        $activityNineOrTenResponse = match ($stepEightResponse['response']) {
            true => $activityNine->execute($stepEightResponse['message']),
            false => $activityTen->execute($stepEightResponse['message'])
        };

        return $activityEnd->execute($activityNineOrTenResponse);
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
     *     SavenActivity,
     *     EightActivity,
     *     NineActivity,
     *     TenActivity,
     *     EndActivity
     * }
     * @throws \Exception
     */

    public function initActivities(): array
    {
        /** @var OneActivity $activityOne */
        $activityOne = $this->make(OneActivity::class);
        /** @var TwoActivity $activityTwo */
        $activityTwo = $this->make(TwoActivity::class);
        /** @var ThreeActivity $activityThree */
        $activityThree = $this->make(ThreeActivity::class);
        /** @var FourActivity $activityFour */
        $activityFour = $this->make(FourActivity::class);
        /** @var FiveActivity $activityFive */
        $activityFive = $this->make(FiveActivity::class);
        /** @var SixActivity $activitySix */
        $activitySix = $this->make(SixActivity::class);
        /** @var SavenActivity $activitySaven */
        $activitySaven = $this->make(SavenActivity::class);
        /** @var EightActivity $activityEight */
        $activityEight = $this->make(EightActivity::class);
        /** @var NineActivity $activityNine */
        $activityNine = $this->make(NineActivity::class);
        /** @var TenActivity $activityTen */
        $activityTen = $this->make(TenActivity::class);
        /** @var EndActivity $activityEnd */
        $activityEnd = $this->make(EndActivity::class);

        return [
            $activityOne,
            $activityTwo,
            $activityThree,
            $activityFour,
            $activityFive,
            $activitySix,
            $activitySaven,
            $activityEight,
            $activityNine,
            $activityTen,
            $activityEnd
        ];
    }


}