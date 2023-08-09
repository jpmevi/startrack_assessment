<?php

namespace App\Http\Controllers;

use App\Http\Processes\StatProcess;
use Illuminate\Http\Request;


class StatController extends Controller
{
    private $statProcess;



    /**
     * StatController constructor.
     * @param StatProcess $statProcess
     */
    public function __construct(StatProcess $statProcess)
    {
        $this->statProcess = $statProcess;
    }



    /**
     * Handle the request to retrieve stat results.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request instance.
     * @return \Illuminate\Http\JsonResponse       The response containing stat results and status code.
     * 
     * 
     * @OA\Get(
     *     path="/api/stat",
     *     tags={"Stat"},
     *     operationId="/api/stat",
     *     description="Handle the request to retrieve stat results",
     * @OA\Parameter(
     *          name="query",
     *          in="query",
     *          description="Filter by Query parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * @OA\Parameter(
     *          name="startDate",
     *          in="query",
     *          description="Filter by Start Date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * @OA\Parameter(
     *          name="endDate",
     *          in="query",
     *          description="Filter by End Date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * @OA\Parameter(
     *          name="query",
     *          in="query",
     *          description="Filter by Query parameter",
     *          required=false,
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
     *          description="Pagination Elements Size",
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
     *                        ref="#/components/schemas/StatResource"
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
    public function index(Request $request)
    {
        $response = $this->statProcess->index($request);
        return response()->json($response, $response['code']);
    }
}
