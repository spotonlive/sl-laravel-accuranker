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
     * @return Keyword|null
     */
    private function convertResponseToKeyword(array $response)
    {
        $keyword = new Keyword(
            $response['id'],
            $response['domain'],
            $response['keyword'],
            $response['location'],
            $response['search_engine'],
            $response['ignore_local_results'],
            DateTime::createFromFormat('Y-m-d His', $response['created_at'] . ' 00000'),
            $response['search_locale'],
            $response['starred'],
            $response['search_volume'],
            $response['tags']
        );

        foreach ($response['history'] as $historyResult) {
            $rank = new Rank(
                new DateTime($historyResult['search_date']),
                $historyResult['rank'],
                $historyResult['url'],
                $historyResult['est_traffic'],
                $historyResult['extra_ranks']
            );
            
            $keyword->addHistory($rank);
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
