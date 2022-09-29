<?php

namespace App\Application\Infrastructure;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    /**
     * ApiResponse constructor.
     * @param array $data
     * @param bool $status
     * @param int $statusCode
     * @param array $headers
     * @param bool $json
     */
    public function __construct($data = [], bool $status = true, int $statusCode = 200, array $headers = [], bool $json = false)
    {
        parent::__construct($this->format($status, $data), $statusCode, $headers, $json);
    }

    /**
     * Format the API response.
     *
     * @param bool $status
     * @param mixed $data
     *
     * @return array
     */
    private function format(bool $status, $data = [])
    {
        return [
            'status' => $status,
            $status ? 'data' : 'errors' => $data,
        ];
    }
}