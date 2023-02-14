<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    schema: 'SkillResource',
    properties: [
        new OAT\Property(
            property: 'uuid', 
            type: 'string', 
            example: '717f46a9-1d19-4527-af39-ae872c951f17'
        ),
        new OAT\Property(
            property: 'name', 
            type: 'string', 
            example: 'My Skill'
        ),
        new OAT\Property(
            property: 'description', 
            type: 'string', 
            example: 'My Description'
        ),
        new OAT\Property(
            property: 'created_at', 
            type: 'datetime', 
            example: '2022-08-27T16:14:46.000000Z'
        ),
    ]
)]
class SkillResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
