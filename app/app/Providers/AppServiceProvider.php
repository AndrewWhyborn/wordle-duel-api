<?php

namespace App\Providers;

use App\Repository\Game\GameRepository;
use App\Repository\Game\GameRepositoryInterface;
use App\Services\StringGenerator\RandomStringGenerator;
use App\Services\StringGenerator\RandomStringGeneratorInterface;
use App\Services\Token\CheckAvailableTokenService;
use App\Services\Token\CheckAvailableTokenServiceInterface;
use App\Services\Word\CheckWordExistenceServiceInterface;
use App\Services\Word\CompareLettersService;
use App\Services\Word\CompareLettersServiceInterface;
use App\Services\YandexDictionary\CheckWordExistenceService;
use App\Services\YandexDictionary\Http\LookupHttpService;
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

        $this->app->bind(
            GameRepositoryInterface::class,
            GameRepository::class
        );

        $this->app->bind(
            CompareLettersServiceInterface::class,
            CompareLettersService::class
        );

        $this->app->bind(
            CheckAvailableTokenServiceInterface::class,
            CheckAvailableTokenService::class
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
