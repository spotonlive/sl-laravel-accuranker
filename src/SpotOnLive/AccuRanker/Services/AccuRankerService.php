<?php

namespace SpotOnLive\AccuRanker\Services;

use DateTime;
use DateTimeZone;
use SpotOnLive\AccuRanker\Exceptions\InvalidAPICallException;
use SpotOnLive\AccuRanker\Exceptions\InvalidCredentialsException;
use SpotOnLive\AccuRanker\Models\Keyword;
use SpotOnLive\AccuRanker\Models\Rank;
use SpotOnLive\AccuRanker\Options\ApiOptions;

class AccuRankerService implements AccuRankerServiceInterface
{
    /** @var ApiOptions */
    protected $config;

    /** @var CurlServiceInterface */
    protected $curlService;

    /**
     * @param array $config
     * @param CurlServiceInterface $curlService
     */
    public function __construct(array $config, CurlServiceInterface $curlService)
    {
        $this->config = new ApiOptions($config);
        $this->curlService = $curlService;
    }

    /**
     * List keywords for domain
     *
     * @param integer $domainId
     * @return array
     */
    public function listKeywordsForDomain($domainId)
    {
        $results = $this->get('domains/' . $domainId . '/keywords/');
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
        $response = $this->get('keywords/' . $keywordId . '/');

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

        $response = $this->post('domains/' . $domainId . '/keywords/', $body);

        return $this->convertResponseToKeyword($response);
    }

    /**
     * @param $domainId
     * @param $id
     * @return null
     */
    public function deleteKeywordsForDomain($domainId, $id)
    {
        $response = $this->delete('domains/' . $domainId . '/keywords/' . $id . '/');

        return null;
    }

    /**
     * Call the CURL get service
     *
     * @param string $url
     * @return array
     * @throws InvalidAPICallException
     * @throws InvalidCredentialsException
     */
    public function get($url)
    {
        $result = $this->curlService->get(
            $this->getUrl() . $url,
            $this->getToken()
        );

        return $this->parse($result);
    }

    /**
     * Call the CURL post service
     *
     * @param string $url
     * @param array $body
     * @return array
     * @throws InvalidAPICallException
     * @throws InvalidCredentialsException
     */
    public function post($url, $body)
    {
        $result = $this->curlService->post(
            $this->getUrl() . $url,
            $this->getToken(),
            $body
        );

        return $this->parse($result);
    }

    /**
     * Call the CURL delete service
     *
     * @param $url
     * @return array
     */
    public function delete($url)
    {
        $result = $this->curlService->delete(
            $this->getUrl() . $url,
            $this->getToken()
        );

        return $this->parse($result);
    }

    /**
     * Parse result
     *
     * @param $result
     * @return array
     * @throws InvalidAPICallException
     */
    public function parse($result)
    {
        $array = json_decode($result, true);

        if (isset($array['detail'])) {
            throw new InvalidAPICallException(
                sprintf(
                    'AccuRanker API error: %s',
                    $array['detail']
                )
            );
        }

        return $array;
    }

    /**
     * Get AccuRanker token
     *
     * @return string
     * @throws InvalidCredentialsException
     */
    protected function getToken()
    {
        /** @var string|null $token */
        $token = env('ACCURANKER_TOKEN', null);

        if (is_null($token)) {
            throw new InvalidCredentialsException('Please insert your accuranker token in the .env file');
        }

        return $token;
    }

    /**
     * Get API Url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->config->get('api_url');
    }

    /**
     * @param ApiOptions $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return ApiOptions
     */
    public function getConfig()
    {
        return $this->config;
    }
}
