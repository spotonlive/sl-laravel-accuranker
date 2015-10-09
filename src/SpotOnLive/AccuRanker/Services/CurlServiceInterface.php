<?php

namespace SpotOnLive\AccuRanker\Services;

interface CurlServiceInterface
{
    /**
     * Curl
     *
     * @param string $url
     * @param string $credentials
     * @return string
     */
    public function curl($url, $credentials);
}
