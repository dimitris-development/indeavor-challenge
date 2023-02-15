<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OAT;

class UpdateSkillRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[OAT\Schema(
        schema: 'UpdateSkillRequest',
        required: ['name', 'description'],
        properties: [
            new OAT\Property(
                property: 'name',
                type: 'string',
                example: 'My Skill name'
            ),
            new OAT\Property(
                property: 'description',
                type: 'string',
                example: 'My Skill description'
            ),
        ]
    )]
    public function rules()
    {
        return [
            'name' => 'required|unique:skill|max:100',
            'description' => 'required|max:255'
        ];
    }
}
