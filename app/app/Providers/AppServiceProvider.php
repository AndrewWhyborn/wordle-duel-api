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

        $this
            ->app
            ->when($yandexDictionaryServices)
            ->needs(RequestFactoryInterface::class)
            ->give(HttpFactory::class)
        ;

        $this
            ->app
            ->when($yandexDictionaryServices)
            ->needs(LoggerInterface::class)
            ->give(fn(Application $app) => new LogManager($app))
        ;

        $this
            ->app
            ->when($yandexDictionaryServices)
            ->needs('$apiKey')
            ->giveConfig('yandex-dictionary.apiKey')
        ;

        $this
            ->app
            ->when(GenerateTokenService::class)
            ->needs(RandomStringGeneratorInterface::class)
            ->give(RandomStringGenerator::class)
        ;

        $this
            ->app
            ->when(WordExists::class)
            ->needs(CheckWordExistenceServiceInterface::class)
            ->give(CheckWordExistenceService::class)
        ;
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
