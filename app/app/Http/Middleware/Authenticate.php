<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Enum\ApiHeaderEnum;
use App\Http\Resources\ExceptionResource;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware для проверки ключа API.
 */
class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $xAuthToken = $request->header(ApiHeaderEnum::X_AUTH_TOKEN);

            if (
                $xAuthToken === null
                || $xAuthToken !== \config('api.xAuthToken')
            ) {
                throw new \Exception(
                    message: \sprintf(
                        'Укажите корректный заголовок %s.',
                        ApiHeaderEnum::X_AUTH_TOKEN
                    ),
                    code: 401
                );
            }
        } catch (\Throwable $exception) {
            return response()
                ->json(
                    data: new ExceptionResource($exception),
                    status: $exception->getCode(),
                );
        }

        return $next($request);
    }
}
