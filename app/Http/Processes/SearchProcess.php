<?php

namespace App\Http\Processes;

use App\Http\Transformers\BaseTransformer;
use App\Http\Validators\SearchValidator;
use App\Services\StackExchangeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as IlluminateResponse;

class SearchProcess
{

    private $baseTransformer;


    /**
     * SearchProcess constructor.
     * @param BaseTransformer $baseTransformer
     */
    public function __construct(
        BaseTransformer $baseTransformer,
    ) {
        $this->baseTransformer = $baseTransformer;
    }

  
    public function index(Request $request)
    {
       
    }
}
