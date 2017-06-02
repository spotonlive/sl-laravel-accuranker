<?php

namespace SpotOnLive\AccuRanker\Resources\Contracts;

interface KeywordsInterface
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
     * @return array
     */
    public function createKeywordForDomain($domainId, $keyword, $searchType, $searchEngine, $optional = []);

    /**
     * @param $domainId
     * @param $id
     * @return array
     */
    public function deleteKeywordsForDomain($domainId, $id);
}
