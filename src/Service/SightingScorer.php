<?php

namespace App\Service;

use App\Entity\BigFootSighting;
use App\Model\BigFootSightingScore;
use App\Scoring\ScoringFactorInterface;

class SightingScorer
{
    /**
     * @var ScoringFactorInterface[]
     */
    private array $scoringFactors;

    public function __construct(array $scoringFactors) {

        $this->scoringFactors = $scoringFactors;
    }

    public function score(BigFootSighting $sighting): BigFootSightingScore
    {
        $score = 0;
        foreach ($this->scoringFactors as $factor) {
            $score += $factor->score($sighting);
        }

        return new BigFootSightingScore($score);
    }
}
