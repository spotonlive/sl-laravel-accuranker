<?php

namespace SpotOnLive\AccuRanker\Options;

class ApiOptions extends Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [
        'curl_timeout' => 60,
    ];
}
