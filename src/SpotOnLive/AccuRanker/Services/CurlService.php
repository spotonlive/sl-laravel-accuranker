<?php

namespace SpotOnLive\AccuRanker\Services;

use SpotOnLive\AccuRanker\Options\ApiOptions;

class CurlService implements CurlServiceInterface
{
    /** @var ApiOptions */
    protected $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new ApiOptions($config);
    }


    /**
     * @param string $url
     * @param string $token
     * @param array $params
     * @return string
     */
    public function get($url, $token, $params = [])
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->config->get('curl_timeout'));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization:' . $token]);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }


    /**
     * @param string $url
     * @param string $token
     * @param array $body
     * @return string
     */
    public function post($url, $token, $body = [])
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->config->get('curl_timeout'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization:' . $token]);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
