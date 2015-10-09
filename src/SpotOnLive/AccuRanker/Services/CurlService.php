<?php

namespace SpotOnLive\AccuRanker\Services;

class CurlService implements CurlServiceInterface
{
    /**
     * Curl
     *
     * @param string $url
     * @param string $token
     * @param array $params
     * @return string
     */
    public function curl($url, $token, $params = [])
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization:' . $token]);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
