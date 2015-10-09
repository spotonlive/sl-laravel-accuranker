<?php

namespace SpotOnLive\AccuRanker\Services;

interface CurlServiceInterface
{
    /**
     * Curl
     *
     * @param string $url
     * @param string $token
     * @return string
     */
    public function curl($url, $token);
}
