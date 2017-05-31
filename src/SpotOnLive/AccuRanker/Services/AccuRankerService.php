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
