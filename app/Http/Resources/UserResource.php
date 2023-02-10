<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    schema: 'UserResource',
    properties: [
        new OAT\Property(
            property: 'uuid', 
            type: 'string', 
            example: '717f46a9-1d19-4527-af39-ae872c951f17'
        ),
        new OAT\Property(
            property: 'name', 
            type: 'string', 
            example: 'John Doe'
        ),
        new OAT\Property(
            property: 'email', 
            type: 'string', 
            example: 'john@example.com'
        ),
        new OAT\Property(
            property: 'role', 
            type: 'object', 
            ref: '#/components/schemas/RoleResource'
        ), 
        new OAT\Property(
            property: 'created_at', 
            type: 'datetime', 
            example: '2022-08-27T16:14:46.000000Z'
        ),
    ]
)]
class UserResource extends JsonResource
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
            'email' => $this->email,
            'role' => new RoleResource($this->whenLoaded('role')),
            'created_at' => $this->created_at,
        ];
    }
}
