<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'payment-complete'
    ];

    public function handle($request, Closure $next)
    {
        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->inExceptArray($request) ||
            $this->tokensMatch($request)
        ) {
            info("am inside");
            return tap($next($request), function ($response) use ($request) {
                if ($this->shouldAddXsrfTokenCookie()) {
                    info("am inside 2");
                    $this->addCookieToResponse($request, $response);
                }
            });
        }

        dd(request()->all(), "am inside");
	return redirect()->route("public.login")->with('message', 'Page Expired');
        // throw new TokenMismatchException('CSRF token mismatch.');
    }
}
