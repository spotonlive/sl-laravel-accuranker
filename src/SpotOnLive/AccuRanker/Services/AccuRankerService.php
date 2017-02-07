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
        $results = $this->api('domains/' . $domainId . '/keywords/');
        $keywords = [];

        foreach ($results as $result) {
            // Keyword
            $keyword = new Keyword();
            $keyword->setId($result['id']);
            $keyword->setDomain($result['domain']);
            $keyword->setKeyword($result['keyword']);
            $keyword->setLocation($result['location']);
            $keyword->setSearchEngine($result['search_engine']);
            $keyword->setIgnoreLocalResults($result['ignore_local_results']);
            $keyword->setCreatedAt(\DateTime::createFromFormat('Y-m-d His', $result['created_at'] . ' 00000'));
            $keyword->setSearchLocale($result['search_locale']);
            $keyword->setStarred($result['starred']);
            $keyword->setTags($result['tags']);
            $keyword->setSearchVolume($result['search_volume']);

            // Rank
            $rank = new Rank();
            $rank->setSearchDate(new \DateTime($result['rank']['search_date']));
            $rank->setRank($result['rank']['rank']);
            $rank->setUrl($result['rank']['url']);
            $rank->setEstTraffic($result['rank']['est_traffic']);
            $rank->setExtraRanks($result['rank']['extra_ranks']);

            $keyword->setRank($rank);

            $keywords[] = $keyword;
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
        $result = $this->api('keywords/' . $keywordId . '/');

        $keyword = new Keyword();

        $keyword->setId($result['id']);
        $keyword->setDomain($result['domain']);
        $keyword->setKeyword($result['keyword']);
        $keyword->setLocation($result['location']);
        $keyword->setSearchEngine($result['search_engine']);
        $keyword->setIgnoreLocalResults($result['ignore_local_results']);
        $keyword->setCreatedAt(\DateTime::createFromFormat('Y-m-d His', $result['created_at'] . ' 00000'));
        $keyword->setSearchLocale($result['search_locale']);
        $keyword->setStarred($result['starred']);
        $keyword->setTags($result['tags']);
        $keyword->setSearchVolume($result['search_volume']);

        foreach ($result['history'] as $historyResult) {
            $rank = new Rank();
            $rank->setSearchDate(new \DateTime($historyResult['search_date']));
            $rank->setRank($historyResult['rank']);
            $rank->setUrl($historyResult['url']);
            $rank->setEstTraffic($historyResult['est_traffic']);
            $rank->setExtraRanks($historyResult['extra_ranks']);

            $keyword->addHistory($rank);
        }

        return $keyword;
    }

    /**
     * Call API
     *
     * @param string $url
     * @return array
     * @throws InvalidAPICallException
     * @throws InvalidCredentialsException
     */
    public function api($url)
    {
        $result = $this->curlService->curl(
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
