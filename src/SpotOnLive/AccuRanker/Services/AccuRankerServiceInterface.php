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

    /**
     * @param $domainId
     * @param $keyword
     * @param $searchType
     * @param $searchEngine
     * @param array $optional
     * @return mixed
     */
    public function createKeywordForDomain($domainId, $keyword, $searchType, $searchEngine, $optional = []);

    /**
     * @param $domainId
     * @param $id
     * @return mixed
     */
    public function deleteKeywordsForDomain($domainId, $id);

}
