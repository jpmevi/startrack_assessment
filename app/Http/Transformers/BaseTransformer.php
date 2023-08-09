<?php

namespace App\Http\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BaseTransformer
{

    /**
     * @param $code
     * @param $status
     * @param $message
     * @param null $data
     * @param null $warning
     * @param null $error
     * @return array
     */
    public function transformToApiResponse(int $code, string $status, string $message, mixed $data = null, string $warning = null, string $error = null)
    {
        return [
            'code' => $code,
            'status' => $status,
            'message' => $message ? $message : Response::$statusTexts[$code],
            'data' => $data,
            'warning' => $warning,
            'error' => $error
        ];
    }

    /**
     * @param $code
     * @param $status
     * @param $message
     * @param LengthAwarePaginator $page
     * @param $data
     * @param null $warning
     * @param null $error
     * @return array
     */
    public function transformToApiResponsePaginate(int $code, string $status, string $message, LengthAwarePaginator $page, mixed $data, string $warning = null, string $error = null, mixed $optionalPage = null)
    {
        return [
            'code' => $code,
            'status' => $status,
            //            'message' => $message ?? '',
            'message' => $message,
            'data' => $data,
            'total' => $optionalPage ? $page->total() + $optionalPage->total :  $page->total(),
            'lastPage' => $optionalPage ? ($page->lastPage() ? $page->lastPage() : $optionalPage->lastPage) : $page->lastPage(),
            'currentPage' => $optionalPage ? ($page->currentPage() ? $page->currentPage() : $optionalPage->currentPage) : $page->currentPage(),
            'perPage' => $page->perPage(),
            'nextPageUrl' => $optionalPage ? ($page->nextPageUrl() ? $page->nextPageUrl() : $optionalPage->nextPageUrl) : $page->nextPageUrl(),
            'previousPageUrl' => $optionalPage ? ($page->previousPageUrl() ? $page->previousPageUrl() : $optionalPage->previousPageUrl) : $page->previousPageUrl(),
            'warning' => $warning,
            'error' => $error
        ];
    }

    /**
     * @param \Exception $e
     * @return array
     */
    public function transformToApiResponseFromException(\Throwable $e)
    {
        $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        $status = 'error';
        $message = Response::$statusTexts[$code] . $this->getMessageFromException($e);
        return $this->transformToApiResponse($code, $status, $message);
    }

    /**
     * @param \Exception $e
     * @return array|null|string
     */
    public function getMessageFromException(\Throwable $e)
    {
        return config('app.env') !== 'production' ?
            $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine() :
            __('error.repository_on_create');
    }

    /**
     * @param $code
     * @param $status
     * @param $message
     * @param $errors
     * @return array
     */
    public function transformFailValidationResponse(int $code, string $status, string $message, mixed $errors)
    {
        return [
            'code' => $code,
            'status' => $status,
            'message' => $message ? $message : Response::$statusTexts[$code],
            'errors' => $errors
        ];
    }
}
