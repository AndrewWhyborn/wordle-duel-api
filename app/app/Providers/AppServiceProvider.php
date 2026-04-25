<?php

namespace App\Providers;

use App\Rules\YandexDictionary\WordExists;
use App\Service\StringGenerator\RandomStringGenerator;
use App\Service\StringGenerator\RandomStringGeneratorInterface;
use App\Service\Token\GenerateTokenService;
use App\Service\Word\CheckWordExistenceServiceInterface;
use App\Service\YandexDictionary\CheckWordExistenceService;
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
            ->give(fn() => new Client(
                config: [
                    'base_uri' => config('yandex-dictionary.baseUrl')
                ]
            ))
        ;

        $this->app->bind(
            RequestFactoryInterface::class,
            HttpFactory::class
        );

        $this->app->bind(
            LoggerInterface::class,
            fn(Application $app) => new LogManager($app)
        );

        $this
            ->app
            ->when($yandexDictionaryServices)
            ->needs('$apiKey')
            ->giveConfig('yandex-dictionary.apiKey')
        ;

        $this->app->bind(
            RandomStringGeneratorInterface::class,
            RandomStringGenerator::class
        );

        $this->app->bind(
            CheckWordExistenceServiceInterface::class,
            CheckWordExistenceService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
