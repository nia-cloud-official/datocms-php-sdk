<?php

namespace DatoCMS\Retry;

use GuzzleHttp\Middleware;
use GuzzleHttp\RetryMiddleware;

class RetryMiddleware
{
    public static function exponentialBackoff(int $maxRetries): callable
    {
        return Middleware::retry(
            function ($retries, $request, $response, $exception) use ($maxRetries) {
                return $retries < $maxRetries && (
                    $exception instanceof \GuzzleHttp\Exception\ServerException ||
                    ($response && $response->getStatusCode() >= 500)
                );
            },
            function ($retries) {
                return (int) pow(2, $retries) * 1000;
            }
        );
    }
}
