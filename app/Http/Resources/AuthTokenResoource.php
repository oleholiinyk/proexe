<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthTokenResoource extends JsonResource
{
    public static $wrap = null;
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'status' => $this->resource['status'],
            'token' => $this->resource['token']
        ];
    }
}
