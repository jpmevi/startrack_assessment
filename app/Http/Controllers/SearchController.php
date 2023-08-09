<?php

namespace App\Http\Controllers;

use App\Http\Processes\SearchProcess;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $searchProcess;


    /**
     * SearchController constructor.
     * @param SearchProcess $searchProcess
     */
    public function __construct(SearchProcess $searchProcess)
    {
        $this->searchProcess = $searchProcess;
    }


    /**
     * Handle the request to retrieve search results.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request instance.
     * @return \Illuminate\Http\JsonResponse       The response containing search results and status code.
     */
    public function search(Request $request)
    {
        $response = $this->searchProcess->index($request);
        return response()->json($response, $response['code']);
    }
}