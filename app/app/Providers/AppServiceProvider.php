<?php

namespace App\Providers;

use App\Service\YandexDictionary\Http\LookupHttpService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Illuminate\Foundation\Application;
use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $yandexDictionaryServices = [
            LookupHttpService::class
        ];

        $this
            ->app
            ->when($yandexDictionaryServices)
            ->needs(ClientInterface::class)
            ->give(fn() => new Client(['base_uri' => config('yandex-dictionary.baseUrl')]))
        ;

        $this
            ->app
            ->when($yandexDictionaryServices)
            ->needs(RequestFactoryInterface::class)
            ->give(fn() => new HttpFactory())
        ;

        $this
            ->app
            ->when($yandexDictionaryServices)
            ->needs(LoggerInterface::class)
            ->give(fn(Application $app) => new LogManager($app))
        ;

        $this->app->when($yandexDictionaryServices)->needs('$apiKey')->giveConfig('yandex-dictionary.apiKey');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
