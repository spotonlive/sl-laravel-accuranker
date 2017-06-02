<?php

namespace SpotOnLive\AccuRanker\Options;

class ApiOptions extends Options implements OptionsInterface
{
    /** @var String array */
    protected $defaults = [
        'api_key' => '',
        'curl_timeout' => 60,
    ];
}
