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
        $this->app->bind('SpotOnLive\AccuRanker\Services\AccuRankerService', function (Application $app) {
            if (!$config = config('accuranker')) {
                $config = [];
            }

            $curlService = $app->make('SpotOnLive\AccuRanker\Services\CurlService');

            return new AccuRankerService($config, $curlService);
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
}
