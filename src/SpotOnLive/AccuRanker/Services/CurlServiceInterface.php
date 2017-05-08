<?php

namespace SpotOnLive\AccuRanker\Services;

interface CurlServiceInterface
{
    /**
     * @param string $url
     * @param string $token
     * @return string
     */
    public function get($url, $token);

    /**
     * @param $url
     * @param $token
     * @param $body
     * @return string
     */
    public function post($url, $token, $body);
}
