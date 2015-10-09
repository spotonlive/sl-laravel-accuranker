<?php

namespace SpotOnLive\AccuRanker\Services;

use DateTime;
use DateTimeZone;
use SpotOnLive\AccuRanker\Exceptions\InvalidAPICallException;
use SpotOnLive\AccuRanker\Exceptions\InvalidCredentialsException;
use SpotOnLive\AccuRanker\Models\Call;
use SpotOnLive\AccuRanker\Models\CallInterface;
use SpotOnLive\AccuRanker\Models\Customer;
use SpotOnLive\AccuRanker\Models\CustomerAddress;
use SpotOnLive\AccuRanker\Models\CustomerInterface;
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
