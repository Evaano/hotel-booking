<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $type = 'default'): Response
    {
        $key = $this->resolveRequestSignature($request, $type);

        // Define rate limits based on type
        $limits = $this->getRateLimits($type);

        // Check if user has exceeded rate limit
        if (RateLimiter::tooManyAttempts($key, $limits['max_attempts'])) {
            $retryAfter = RateLimiter::availableIn($key);

            return response()->json([
                'error' => 'Rate limit exceeded',
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => $retryAfter,
                'limit' => $limits['max_attempts'],
                'window' => $limits['decay_minutes'].' minutes',
            ], 429)->header('Retry-After', $retryAfter);
        }

        // Increment attempt counter
        RateLimiter::hit($key, $limits['decay_minutes'] * 60);

        // Add rate limit headers to response
        $response = $next($request);

        $response->headers->add([
            'X-RateLimit-Limit' => $limits['max_attempts'],
            'X-RateLimit-Remaining' => RateLimiter::remaining($key, $limits['max_attempts']),
            'X-RateLimit-Reset' => time() + RateLimiter::availableIn($key),
        ]);

        return $response;
    }

    /**
     * Resolve the request signature for rate limiting
     */
    protected function resolveRequestSignature(Request $request, string $type): string
    {
        $identifier = 'api';

        // Add user-specific identifier if authenticated
        if ($request->user()) {
            $identifier .= ':user:'.$request->user()->id;
        } else {
            // Use IP address for unauthenticated requests
            $identifier .= ':ip:'.$request->ip();
        }

        // Add type-specific identifier
        $identifier .= ':'.$type;

        return $identifier;
    }

    /**
     * Get rate limits based on request type
     */
    protected function getRateLimits(string $type): array
    {
        $limits = [
            'default' => [
                'max_attempts' => 60,
                'decay_minutes' => 1,
            ],
            'auth' => [
                'max_attempts' => 5,
                'decay_minutes' => 15,
            ],
            'booking' => [
                'max_attempts' => 10,
                'decay_minutes' => 1,
            ],
            'search' => [
                'max_attempts' => 100,
                'decay_minutes' => 1,
            ],
            'verification' => [
                'max_attempts' => 20,
                'decay_minutes' => 1,
            ],
            'reporting' => [
                'max_attempts' => 30,
                'decay_minutes' => 1,
            ],
        ];

        return $limits[$type] ?? $limits['default'];
    }
}
