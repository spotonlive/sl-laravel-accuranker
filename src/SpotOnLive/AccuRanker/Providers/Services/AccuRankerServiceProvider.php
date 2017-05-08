<?php

/**
 * AccuRanker package for Laravel 5.1
 *
 * @license MIT
 * @package SpotOnLive\AccuRanker
 */

namespace SpotOnLive\AccuRanker\Providers\Services;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use SpotOnLive\AccuRanker\Services\AccuRankerService;
use SpotOnLive\AccuRanker\Services\CurlService;

class AccuRankerServiceProvider extends ServiceProvider
{
    /**
     * Publish config
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../../config/config.php' => config_path('accuranker.php'),
        ]);
    }

    /**
     * Register service
     */
    public function register()
    {
        $this->app->bind(AccuRankerService::class, function (Application $app) {
            $curlService = $app->make(CurlService::class);

            return new AccuRankerService($this->getConfig(), $curlService);
        });

        $this->app->bind(CurlService::class, function (Application $app) {
            return new CurlService($this->getConfig());
        });

        $this->mergeConfig();
    }

    /**
     * Merge condfig
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../../config/config.php',
            'accuranker'
        );
    }

    /**
     * @return array
     */
    private function getConfig()
    {
        if (!$config = config('accuranker')) {
            return [];
        }

        return $config;
    }
}
