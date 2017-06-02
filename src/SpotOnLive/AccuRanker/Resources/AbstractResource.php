<?php

namespace SpotOnLive\AccuRanker\Resources;

use SpotOnLive\AccuRanker\AccuRanker;

abstract class AbstractResource
{
    /** @var AccuRanker */
    protected $accuRanker;

    /**
     * AbstractResource constructor.
     * @param AccuRanker $accuRanker
     */
    public function __construct(AccuRanker $accuRanker)
    {
        $this->accuRanker = $accuRanker;
    }
}
