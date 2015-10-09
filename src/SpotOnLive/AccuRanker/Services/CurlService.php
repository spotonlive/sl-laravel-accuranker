<?php

namespace SpotOnLive\AccuRanker\Services;

class CurlService implements CurlServiceInterface
{
    /**
     * @param string $url
     * @param string $credentials
     * @return string
     */
    public function curl($url, $credentials)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($curl, CURLOPT_USERPWD, $credentials);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
