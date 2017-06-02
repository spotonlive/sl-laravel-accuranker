<?php

namespace SpotOnLive\AccuRanker\Resources;

use DateTime;
use JamesHalsall\Hydrator\ObjectConstructorFromArrayHydrator;
use SpotOnLive\AccuRanker\Models\Keyword;
use SpotOnLive\AccuRanker\Models\Rank;
use SpotOnLive\AccuRanker\Resources\Contracts\KeywordsInterface;

class Keywords extends AbstractResource implements KeywordsInterface
{
    /**
     * List keywords for domain
     *
     * @param integer $domainId
     * @return array
     */
    public function listKeywordsForDomain($domainId)
    {
        $results = $this->accuRanker->get('domains/' . $domainId . '/keywords/');
        // init keywords with empty array
        $keywords = [];

        foreach ($results as $result) {
            $keywords[] = $this->convertResponseToKeyword($result);
        }

        return $keywords;
    }

    /**
     * List keyword history
     *
     * @param string $keywordId
     * @return Keyword
     */
    public function listKeywordHistory($keywordId)
    {
        $response = $this->accuRanker->get('keywords/' . $keywordId . '/');

        return $this->convertResponseToKeyword($response);
    }

    /**
     * Convert response to keyword model
     *
     * @param array $response
     * @return Keyword
     */
    private function convertResponseToKeyword(array $response)
    {
        $hydrator = new ObjectConstructorFromArrayHydrator();

        // History
        $history = [];

        if (isset($response['history'])) {
            $history = $response['history'];
        }

        // Rank
        $rank = null;

        if (isset($response['rank'])) {
            $rank = $response['rank'];
        }

        $response['rank'] = null;

        $keyword = $hydrator->hydrate(Keyword::class, $response);

        foreach ($history as $historyResult) {
            $rank = $hydrator->hydrate(Rank::class, $historyResult);
            $keyword->addHistory($rank);
        }

        if ($rank) {
            $rank = $hydrator->hydrate(Rank::class, $rank);
            $keyword->setRank($rank);
        }

        return $keyword;
    }

    /**
     * @param integer $domainId
     * @param string $keyword
     * @param string $searchType
     * @param string $searchEngine
     * @param array $optional
     * @return Keyword
     */
    public function createKeywordForDomain($domainId, $keyword, $searchType, $searchEngine, $optional = [])
    {
        $body = array_merge([
            'keyword' => $keyword,
            'search_type' => $searchType,
            'search_engine' => $searchEngine,
        ], $optional);

        $response = $this->accuRanker->post('domains/' . $domainId . '/keywords/', $body);

        return $this->convertResponseToKeyword($response);
    }

    /**
     * @param $domainId
     * @param $id
     * @return null
     */
    public function deleteKeywordsForDomain($domainId, $id)
    {
        return $this->accuRanker->delete('domains/' . $domainId . '/keywords/' . $id . '/');
    }
}
