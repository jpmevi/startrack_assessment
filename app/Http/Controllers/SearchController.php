<?php

namespace App\Http\Controllers;

use App\Http\Processes\SearchProcess;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Startrack Assessment",
 *      description="Startrack Backend Dev. Technical Assessment API",
 *      @OA\Contact(
 *          email="juanmezavi@gmail.com"
 *      )
 * )
 * @OA\Server(url="http://localhost:8000")
 */

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
     * 
     * 
     * @OA\Get(
     *     path="/api/search",
     *     tags={"Search"},
     *     operationId="/api/search",
     *     description="Handle the request to retrieve search results",
     * @OA\Parameter(
     *          name="query",
     *          in="query",
     *          description="Query Parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page Number",
     *          required=false,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\Parameter(
     *          name="pagesize",
     *          in="query",
     *          description="Page Elements Size",
     *          required=false,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="status", type="string", example="Success"),
     *             @OA\Property(property="message", type="string", example="OK"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="title", type="string", example="How to access excell macro using java or java related tech"),
     *                 @OA\Property(property="answer_count", type="integer", example=0),
     *                 @OA\Property(property="username", type="string", example="Ravi"),
     *                 @OA\Property(property="profile_picture", type="string", example="https://www.gravatar.com/avatar/0c729c691cb9ead0fd39576af1a966cb?s=256&d=identicon&r=PG&f=y&so-version=2")
     *             )),
     *             @OA\Property(property="warning", type="string", example=null, nullable=true),
     *             @OA\Property(property="error", type="string", example=null, nullable=true)
     *         )
     *     ),
     *    @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="status", type="string", example="Fail"),
     *             @OA\Property(property="message", type="string", example="Validation Error"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string", example="The query field is required."))
     *         )
     *     ),
     * @OA\Response(
     *         response="default",
     *         description="Unproccesable Content",
     *          @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=400),
     *             @OA\Property(property="status", type="string", example="Failure"),
     *             @OA\Property(property="message", type="string", example="Error"),
     *             @OA\Property(property="data", type="array", @OA\Items()),
     *             @OA\Property(property="warning", type="string", example=null, nullable=true),
     *             @OA\Property(property="error", type="string", example=null, nullable=true)
     *         )
     *     )
     * )
     */
    public function search(Request $request)
    {
        $response = $this->searchProcess->index($request);
        return response()->json($response, $response['code']);
    }
}
