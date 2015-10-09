<?php

namespace SpotOnLive\AccuRanker\Options;

class ApiOptions extends Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [
        'api_url' => 'https://app.accuranker.com/api/v3',
    ];
}
