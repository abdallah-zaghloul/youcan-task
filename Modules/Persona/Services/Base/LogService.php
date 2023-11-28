<?php

namespace Modules\Persona\Services\Base;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Persona\Repositories\LogRepository;

/**
 *
 */
class LogService
{

    /**
     * @var LogRepository
     */
    protected LogRepository $repository;


    public function __construct()
    {
        $this->repository = app(LogRepository::class);
    }


    /**
     * @param Request $request
     * @param mixed $response
     * @param string|null $guard
     */
    public function execute(Request $request, mixed $response, ?string $guard = null): void
    {
        [$url, $headers, $body, $query, $cookie, $ip, $guard, $id] = [
            $request->fullUrl(),
            getallheaders(),
            $request->post(),
            $request->query(),
            $request->cookie(),
            $request->ip(),
            $guard,
            @auth($guard)->id() ?? 'guest'
        ];

        $requestData = collect(compact('headers', 'body', 'query', 'cookie', 'ip', 'guard', 'id'));
        $responseData = collect(@$response->original ?? @$response['original'] ?? []);

        if (env('APP_ENV') !== 'production')
            [$requestData, $responseData] = [
                $requestData->toJson(JSON_INVALID_UTF8_IGNORE|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS),
                $responseData->toJson(JSON_INVALID_UTF8_IGNORE|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS),
            ];

        $this->repository->create([
            'url' => $url,
            'request' => $requestData,
            'response' => $responseData,
        ]);
    }
}
