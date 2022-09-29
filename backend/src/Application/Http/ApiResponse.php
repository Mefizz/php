<?php

declare(strict_types=1);

namespace App\Application\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    /**
     * ApiResponse constructor.
     *
     * @param array  $data
     * @param bool   $status
     * @param string $message
     * @param int    $statusCode
     * @param array  $headers
     * @param bool   $json
     */
    public function __construct(
        array  $data = [],
        bool   $status = true,
        string $message = '',
        int    $statusCode = 200,
        array  $headers = [],
        bool   $json = false
    )
    {
        $responseData = $status ? [
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ] : [
            'status' => $status,
            'errors' => [
                'detail' => $message,
            ],
        ];

        parent::__construct($responseData, $statusCode, $headers, $json);
    }

    public static function successful(string $message = 'successful', $data = []): self
    {
        return new self($data, true, $message);
    }
}