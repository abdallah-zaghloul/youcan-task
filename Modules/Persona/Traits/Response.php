<?php

namespace Modules\Persona\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Modules\Persona\Enums\HttpStatusCodeEnum;

trait Response
{

    /**
     * @param iterable $errors
     * @param string|null $message
     * @param HttpStatusCodeEnum|null $errorHttpCode
     * @param bool $shouldThrow
     * @param array $headers
     * @param int $options
     * @return mixed
     */
    public function errorResponse(
        iterable            $errors,
        ?string             $message = null,
        ?HttpStatusCodeEnum $errorHttpCode = null,
        bool                $shouldThrow = true,
        array               $headers = [],
        int                 $options = 0
    ): mixed
    {
        $response = response()->json(
            data: [
                'status' => false,
                'message' => $message ?? @trans('persona::messages.bad_request'),
                'errors' => $errors,
            ],
            status: $errorHttpCode->value ?? HttpStatusCodeEnum::BadRequest->value,
            headers: $headers,
            options: $options
        );

        return $shouldThrow ? throw new HttpResponseException($response) : $response;
    }


    /**
     * @param string|null $message
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public function successResponse(
        ?string $message = null,
        array   $headers = [],
        int     $options = 0
    ): JsonResponse
    {
        return response()->json(
            data: [
                'status' => true,
                'message' => $message ?? @trans('persona::messages.success'),
            ],
            status: HttpStatusCodeEnum::Success->value,
            headers: $headers,
            options: $options
        );
    }

    /**
     * @param array $data
     * @param string|null $message
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public function dataResponse(
        iterable $data,
        ?string  $message = null,
        array    $headers = [],
        int      $options = 0
    ): JsonResponse
    {
        return response()->json(
            data: [
                'status' => true,
                'message' => $message ?? @trans('persona::messages.success'),
                'data' => $data,
            ],
            status: HttpStatusCodeEnum::Success->value,
            headers: $headers,
            options: $options
        );
    }


    /**
     * @param string|null $message
     * @param HttpStatusCodeEnum|null $errorHttpCode
     * @param bool $shouldThrow
     * @param array $headers
     * @param int $options
     * @return mixed
     */
    public function errorMessage(
        ?string             $message = null,
        ?HttpStatusCodeEnum $errorHttpCode = null,
        bool                $shouldThrow = true,
        array               $headers = [],
        int                 $options = 0
    ): mixed
    {
        $response = response()->json(
            data: [
                'status' => false,
                'message' => $message ?? @trans('persona::messages.unavailable_server'),
            ],
            status: ($errorHttpCode ?? HttpStatusCodeEnum::UnavailableServer)->value,
            headers: $headers,
            options: $options
        );

        return $shouldThrow ? throw new HttpResponseException($response) : $response;
    }

}
