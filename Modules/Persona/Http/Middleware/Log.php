<?php /** @noinspection PhpLanguageLevelInspection */

namespace Modules\Persona\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Persona\Services\Base\LogService;

/**
 *
 */
class Log
{
    /**
     * @var LogService
     */
    public LogService $service;

    /**
     *
     */
    public function __construct()
    {
        $this->service = app(LogService::class);
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ?string $guard = null): mixed
    {
        $response = $next($request);
        try {
            $this->service->execute($request, $response, $guard);
            return $response;
        } catch (\Exception $exception) {
            return $response;
        }
    }
}
