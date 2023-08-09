<?php

namespace App\Http\Resources\Api\Stat;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="Stat Resource",
 *     description="Stat response data",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="number",
 *     ),
 *     @OA\Property(
 *         property="query",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="page",
 *         type="integer",
 *     ),
 *      @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date",
 *     ),

 * @OA\Property(
 *         property="pagesize",
 *         type="integer",
 *     ),
 * )
 * @OA\Property(
 *         property="site",
 *         type="string",
 *     ),
 * )
 */
class StatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'query' => $this->resource->query,
            'page' => $this->resource->page,
            'pagesize' => $this->resource->pagesize,
            'site' => $this->resource->site,
            'created_at' => $this->resource->created_at,
        ];
    }
}
