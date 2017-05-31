<?php

namespace SpotOnLive\AccuRanker\Resources;

use DateTime;
use SpotOnLive\AccuRanker\Models\Keyword;
use SpotOnLive\AccuRanker\Models\Rank;

class Keywords extends AbstractResource
{
    /**
     * List keywords for domain
     *
     * @param integer $domainId
     * @return array
     */
    public function listKeywordsForDomain($domainId)
    {
        $results = $this->Accuranker->get('domains/' . $domainId . '/keywords/');
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
        $response = $this->Accuranker->get('keywords/' . $keywordId . '/');

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

        if (isset($response['history'])) {
            foreach ($response['history'] as $historyResult) {
                $rank = new Rank();
                $rank->setSearchDate(new DateTime($historyResult['search_date']));
                $rank->setRank($historyResult['rank']);
                $rank->setUrl($historyResult['url']);
                $rank->setEstTraffic($historyResult['est_traffic']);
                $rank->setExtraRanks($historyResult['extra_ranks']);

                $keyword->addHistory($rank);
            }
        }

        if (isset($response['rank'])) {
            // Rank
            $rank = new Rank();
            $rank->setSearchDate(new DateTime($response['rank']['search_date']));
            $rank->setRank($response['rank']['rank']);
            $rank->setUrl($response['rank']['url']);
            $rank->setEstTraffic($response['rank']['est_traffic']);
            $rank->setExtraRanks($response['rank']['extra_ranks']);

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

        $response = $this->Accuranker->post('domains/' . $domainId . '/keywords/', $body);

        return $this->convertResponseToKeyword($response);
    }

    /**
     * @param $domainId
     * @param $id
     * @return null
     */
    public function deleteKeywordsForDomain($domainId, $id)
    {
        $response = $this->Accuranker->delete('domains/' . $domainId . '/keywords/' . $id . '/');

        return null;
    }
}
