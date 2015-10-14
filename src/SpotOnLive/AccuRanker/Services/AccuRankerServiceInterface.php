<?php

namespace SpotOnLive\AccuRanker\Services;

interface AccuRankerServiceInterface
{
    /**
     * List keywords by domain
     *
     * @param string $id
     * @return array
     */
    public function listKeywordsForDomain($id);

    /**
     * Get keyword history
     *
     * @param string $keywordId
     * @return array
     */
    public function listKeywordHistory($keywordId);
}
