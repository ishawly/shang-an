<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TopicCollection extends ResourceCollection
{

    /**
     * only when 'return new TopicCollection($topics);' and specify here will affect
     *
     * @var string
     */
    public static $wrap = 'data';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
//            'data' => TopicResource::collection($this->collection),
            'data' => $this->collection,
            'meta' => [
                'total' => $this->resource->total(),
            ],
        ];
    }

    /**
     * only include certain meta data with a resource response if the resource is the outermost resource being returned.
     * the same as apply additional method on resource directly
     *
     */
    public function with($request)
    {
        return [
            'meta' => ['bar' => 11]
        ];
    }

    /**
     * This method will be call
     * when the resource is returned as the outermost resource in a response
     */
    public function withResponse($request, $response)
    {
        $response->header('X-Value', true);
    }
}
