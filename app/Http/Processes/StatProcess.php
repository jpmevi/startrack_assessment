<?php

namespace App\Http\Processes;

use App\Http\Repositories\StatRepository;
use App\Http\Resources\Api\Stat\StatResource;
use App\Http\Transformers\BaseTransformer;
use App\Http\Validators\StatValidator;
use App\Models\Stat;
use App\Services\StackExchangeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as IlluminateResponse;

class StatProcess
{

    private $baseTransformer;
    private $statRepository;
    /**
     * StatProcess constructor.
     * @param BaseTransformer $baseTransformer
     * @param StatRepository $statRepository
     */
    public function __construct(
        BaseTransformer $baseTransformer,
        StatRepository $statRepository
    ) {
        $this->baseTransformer = $baseTransformer;
        $this->statRepository = $statRepository;
    }

    /**
     * Handles the index (listing) request for statistics.
     * 
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * 
     * @return \Illuminate\Http\Response Returns an HTTP response with the list of statistics or an error message.
     * 
     * @throws \Throwable If there's an unexpected error during execution.
     */
    public function index(Request $request)
    {
        try {
            $pagesize = $request->get('pagesize');
            $startDate = $request->get('startDate');
            $endDate = $request->get('endDate');
            $query = $request->get('query');
            $response = $this->statRepository->getAll($pagesize, $startDate, $endDate, $query);
            $data = StatResource::collection($response->getCollection());
            return $this->baseTransformer->transformToApiResponsePaginate(IlluminateResponse::HTTP_OK, 'Success', trans(''), $response, $data);
        } catch (\Throwable $e) {
            return $this->baseTransformer->transformToApiResponseFromException($e);
        }
    }
}
