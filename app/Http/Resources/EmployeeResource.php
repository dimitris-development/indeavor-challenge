<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    schema: 'EmployeeResource',
    properties: [
        new OAT\Property(
            property: 'uuid', 
            type: 'string', 
            example: '717f46a9-1d19-4527-af39-ae872c951f17'
        ),
        new OAT\Property(
            property: 'first_name',
            type: 'string',
            example: 'John'
        ),
        new OAT\Property(
            property: 'last_name',
            type: 'string', 
            example: 'Doe'
        ),
        new OAT\Property(
            property: 'skills', 
            type: 'object', 
            ref: '#/components/schemas/SkillResource'
        ),
        new OAT\Property(
            property: 'created_at', 
            type: 'datetime', 
            example: '2022-08-27T16:14:46.000000Z'
        ),
    ]
)]
class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'uuid' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'created_at' => $this->created_at,
        ];
    }
}
