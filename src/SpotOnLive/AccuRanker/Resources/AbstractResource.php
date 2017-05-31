<?php

namespace SpotOnLive\AccuRanker\Resources;

use SpotOnLive\AccuRanker\AccuRanker;

abstract class AbstractResource
{
    /** @var  AccuRanker */
    protected $Accuranker;

    /**
     * AbstractResource constructor.
     * @param $Accuranker
     */
    public function __construct(AccuRanker $Accuranker)
    {
        $this->Accuranker = $Accuranker;
    }
}
