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
     * Convert response to keyword
     *
     * @param array $response
     * @return Keyword|null
     */
    private function convertResponseToKeyword(array $response)
    {
        $keyword = new Keyword();
        
        $keyword->setId($response['id']);
        $keyword->setDomain($response['domain']);
        $keyword->setKeyword($response['keyword']);
        $keyword->setLocation($response['location']);
        $keyword->setSearchEngine($response['search_engine']);
        $keyword->setIgnoreLocalResults($response['ignore_local_results']);
        $keyword->setCreatedAt(DateTime::createFromFormat('Y-m-d His', $response['created_at'] . ' 00000'));
        $keyword->setSearchLocale($response['search_locale']);
        $keyword->setStarred($response['starred']);
        $keyword->setTags($response['tags']);
        $keyword->setSearchVolume($response['search_volume']);
        
        // Rank
        
        if (isset($response['rank'])) {
            $keyword->setRank($this->convertResponseToRank($response['rank']));
        }

        // Load history

        if (isset($response['history'])) {
            foreach ($response['history'] as $historyResult) {
                $keyword->addHistory($this->convertResponseToRank($historyResult));
            }
        }
        
        return $keyword;
    }

    /**
     * Convert array response to rank
     *
     * @param array $response
     * @return Rank
     */
    private function convertResponseToRank(array $response)
    {
        $rank = new Rank();

        $rank->setSearchDate(new DateTime($response['search_date']));
        $rank->setRank($response['rank']);
        $rank->setUrl($response['url']);
        $rank->setEstTraffic($response['est_traffic']);
        $rank->setExtraRanks($response['extra_ranks']);

        return $rank;
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
