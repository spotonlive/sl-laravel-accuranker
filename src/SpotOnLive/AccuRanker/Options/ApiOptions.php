<?php

namespace SpotOnLive\AccuRanker\Options;

class ApiOptions extends Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [
        'accuranker_token' => '',
        'curl_timeout' => 60,
    ];
}
