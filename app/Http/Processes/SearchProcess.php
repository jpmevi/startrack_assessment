<?php

namespace App\Http\Processes;

use App\Http\Repositories\StatRepository;
use App\Http\Transformers\BaseTransformer;
use App\Http\Validators\SearchValidator;
use App\Services\StackExchangeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as IlluminateResponse;

class SearchProcess
{

    private $baseTransformer;
    private $stackExchangeService;
    private $searchValidator;
    private $statRepository;

    /**
     * SearchProcess constructor.
     * @param BaseTransformer $baseTransformer
     * @param SearchValidator $searchValidator
     * @param StatRepository $statRepository
     */
    public function __construct(
        BaseTransformer $baseTransformer,
        SearchValidator $searchValidator,
        StatRepository $statRepository
    ) {
        $this->baseTransformer = $baseTransformer;
        $this->searchValidator = $searchValidator;
        $this->stackExchangeService = StackExchangeService::getInstance();
        $this->statRepository = $statRepository;
    }

    /**
     * Handles the index request for searching data.
     * 
     * 1. Validates the search parameters using the searchValidator.
     * 2. Fetches the search results based on the provided query parameters.
     * 3. Transforms the search results to a suitable API response format.
     * 
     * @param  Request $request The incoming HTTP request containing search parameters.
     * @return array            An array representing the API response format.
     * 
     * @throws HttpResponseException If the validation fails.
     * @throws \Throwable            For any other unexpected errors.
     */
    public function index(Request $request): array
    {
        $this->searchValidator->validateSearch($request);
        try {
            $query = $request->get('query');
            $page = $request->get('page');
            $pagesize = $request->get('pagesize');
            $response = $this->stackExchangeService->search($query, $page, $pagesize);
            if ($response['code'] === 200) {
                $this->statRepository->store($query, $page, $pagesize);
                return $this->baseTransformer->transformToApiResponse(IlluminateResponse::HTTP_OK, 'Success', trans(''), $response['data']);
            }
            return $this->baseTransformer->transformToApiResponse($response['code'], 'Failure', trans($response['message']));
        } catch (\Throwable $e) {
            return $this->baseTransformer->transformToApiResponseFromException($e);
        }
    }
}
